<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Семейный кабинет ребёнка' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @fluxAppearance
</head>

<body class="min-h-dvh bg-zinc-50 dark:bg-zinc-900">

    @auth

        {{-- Личный кабинет: мобильная навигация --}}
        <flux:sidebar sticky collapsible="mobile"
            class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

            <flux:sidebar.header>
                <flux:sidebar.brand href="{{ url('/dashboard') }}" name="Семейный кабинет" />

                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.item icon="home" href="{{ url('/dashboard') }}" :current="request()->is('dashboard')">
                    Главная
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <flux:sidebar.spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="cog-6-tooth" href="#">
                    Настройки
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <flux:sidebar.spacer />

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <flux:button type="submit" variant="ghost" icon="arrow-right-start-on-rectangle" class="w-full">
                    Выйти
                </flux:button>
            </form>

        </flux:sidebar>

        {{-- Личный кабинет: верхняя панель --}}
        <flux:header class="border-b border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">

            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:brand href="{{ url('/dashboard') }}" name="Семейный кабинет" class="max-lg:hidden" />

            <flux:navbar class="max-lg:hidden">
                <flux:navbar.item icon="home" href="{{ url('/dashboard') }}" :current="request()->is('dashboard')">
                    Главная
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <flux:dropdown position="top" align="end">

                <flux:profile :name="auth()->user()->name" />

                <flux:menu>
                    <div class="px-3 py-2">
                        <flux:text size="sm">Вы вошли как</flux:text>

                        <flux:heading size="sm" class="mt-1">
                            {{ auth()->user()->email }}
                        </flux:heading>
                    </div>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                            Выйти
                        </flux:menu.item>
                    </form>
                </flux:menu>

            </flux:dropdown>

        </flux:header>

        <flux:main container>
            {{ $slot }}
        </flux:main>
    @else
        {{-- Публичная часть сайта --}}
        <flux:header class="border-b border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">

            <flux:brand href="{{ url('/') }}" name="Семейный кабинет" />

            <flux:navbar class="max-lg:hidden">
                <flux:navbar.item icon="home" href="{{ url('/') }}">
                    Главная
                </flux:navbar.item>

                <flux:navbar.item icon="squares-2x2" href="{{ url('/#features') }}">
                    Возможности
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <flux:button href="{{ route('register') }}" variant="primary" icon="user-plus" size="sm">
                Создать аккаунт
            </flux:button>

        </flux:header>

        <main>
            {{ $slot }}
        </main>

    @endauth

    @livewireScripts
    @fluxScripts

</body>

</html>
