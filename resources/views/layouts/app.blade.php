<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @fluxAppearance
</head>

@php
    // Единый список пунктов меню для шапки и мобильной панели.
    $appNav = [
        ['route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'home', 'label' => 'Дашборд'],
        ['route' => 'groups.index', 'active' => 'groups.*', 'icon' => 'user-group', 'label' => 'Группы'],
        ['route' => 'activity', 'active' => 'activity', 'icon' => 'clock', 'label' => 'Активность'],
    ];

    // Пункты для гостя (ведут на главную и её разделы; разделы добавим позже).
    $publicNav = [
        ['href' => url('/'), 'icon' => 'home', 'label' => 'Главная', 'current' => request()->is('/')],
        [
            'href' => url('/') . '#how-it-works',
            'icon' => 'light-bulb',
            'label' => 'Как это работает',
            'current' => false,
        ],
        ['href' => url('/') . '#features', 'icon' => 'sparkles', 'label' => 'Возможности', 'current' => false],
    ];

    // Итоговый список: один формат для шапки и мобильной панели.
    $items = auth()->check()
        ? collect($appNav)
            ->filter(fn($item) => Route::has($item['route']))
            ->map(
                fn($item) => [
                    'href' => route($item['route']),
                    'icon' => $item['icon'],
                    'label' => $item['label'],
                    'current' => request()->routeIs($item['active']),
                ],
            )
            ->values()
            ->all()
        : $publicNav;

    // Инициалы для аватара-заглушки (до двух букв из имени).
    $user = auth()->user();
    $initials = $user
        ? Str::upper(
            Str::of($user->name)
                ->explode(' ')
                ->filter()
                ->take(2)
                ->map(fn($word) => Str::substr($word, 0, 1))
                ->implode(''),
        )
        : '';
@endphp

<body class="min-h-screen bg-white antialiased dark:bg-zinc-800">

    {{-- ===== Верхняя панель ===== --}}
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-2 font-semibold max-lg:hidden">
            <flux:icon.banknotes class="size-6 text-emerald-600" />
            <span>{{ config('app.name') }}</span>
        </a>

        <flux:navbar class="-mb-px max-lg:hidden">
            @foreach ($items as $item)
                <flux:navbar.item :icon="$item['icon']" :href="$item['href']" :current="$item['current']"
                    wire:navigate>
                    {{ $item['label'] }}
                </flux:navbar.item>
            @endforeach
        </flux:navbar>

        <flux:spacer />

        {{-- Переключатель тёмной темы --}}
        <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
            aria-label="Переключить тёмную тему" />

        @auth
            {{-- Сюда позже добавим колокольчик уведомлений (этап 7) --}}
            <flux:dropdown position="bottom" align="end">
                {{-- Аватар-заглушка: инициалы. Позже сюда добавится avatar="..." --}}
                <flux:profile :initials="$initials" />

                <flux:menu>
                    <div class="px-2 py-1.5">
                        <flux:heading size="sm">{{ $user->name }}</flux:heading>
                        <flux:text size="sm">{{ $user->email }}</flux:text>
                    </div>

                    <flux:menu.separator />

                    @if (Route::has('profile'))
                        <flux:menu.item :href="route('profile')" icon="user" wire:navigate>Профиль</flux:menu.item>
                    @endif

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            Выйти
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @endauth

        @guest
            <div class="flex items-center gap-2">
                @if (Route::has('login'))
                    <flux:button :href="route('login')" variant="ghost" size="sm" wire:navigate>Войти</flux:button>
                @endif
                @if (Route::has('register'))
                    <flux:button :href="route('register')" variant="primary" size="sm" wire:navigate>Регистрация
                    </flux:button>
                @endif
            </div>
        @endguest
    </flux:header>

    {{-- ===== Мобильное меню ===== --}}
    <flux:sidebar sticky collapsible="mobile"
        class="border-r border-zinc-200 bg-zinc-50 lg:hidden dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-2 px-2 font-semibold">
                <flux:icon.banknotes class="size-6 text-emerald-600" />
                <span>{{ config('app.name') }}</span>
            </a>

            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            @foreach ($items as $item)
                <flux:sidebar.item :icon="$item['icon']" :href="$item['href']" :current="$item['current']"
                    wire:navigate>
                    {{ $item['label'] }}
                </flux:sidebar.item>
            @endforeach

            @guest
                @if (Route::has('login'))
                    <flux:sidebar.item icon="arrow-right-end-on-rectangle" :href="route('login')" wire:navigate>Войти
                    </flux:sidebar.item>
                @endif
                @if (Route::has('register'))
                    <flux:sidebar.item icon="user-plus" :href="route('register')" wire:navigate>Регистрация
                    </flux:sidebar.item>
                @endif
            @endguest
        </flux:sidebar.nav>
    </flux:sidebar>

    {{-- ===== Контент страницы ===== --}}
    <flux:main>
        {{ $slot }}
    </flux:main>

    {{-- ===== Футер ===== --}}
    <footer class="col-span-full border-t border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="space-y-3 lg:col-span-2">
                    <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-2 font-semibold">
                        <flux:icon.banknotes class="size-6 text-emerald-600" />
                        <span>{{ config('app.name') }}</span>
                    </a>
                    <flux:text size="sm" class="max-w-sm">
                        Делите расходы с друзьями, соседями и коллегами и всегда знайте, кто кому должен.
                    </flux:text>
                </div>

                <div class="space-y-3">
                    <flux:heading size="sm">Приложение</flux:heading>
                    <div class="flex flex-col gap-2 text-sm">
                        <flux:link :href="url('/')" variant="subtle" wire:navigate>Главная</flux:link>
                        @auth
                            @if (Route::has('dashboard'))
                                <flux:link :href="route('dashboard')" variant="subtle" wire:navigate>Дашборд</flux:link>
                            @endif
                            @if (Route::has('groups.index'))
                                <flux:link :href="route('groups.index')" variant="subtle" wire:navigate>Группы</flux:link>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="space-y-3">
                    <flux:heading size="sm">Проект</flux:heading>
                    <div class="flex flex-col gap-2 text-sm">
                        <flux:link href="#" variant="subtle">О проекте</flux:link>
                        <flux:link href="#" variant="subtle">Политика данных</flux:link>
                        <flux:link href="#" variant="subtle">GitHub</flux:link>
                    </div>
                </div>
            </div>

            <flux:separator class="my-8" />

            <flux:text size="sm">
                © {{ date('Y') }} {{ config('app.name') }}. Приложение ведёт учёт долгов и не переводит деньги.
            </flux:text>
        </div>
    </footer>

    @livewireScripts
    @fluxScripts
</body>

</html>
