
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

        {{-- ========================================= --}}
        {{-- ЛИЧНЫЙ КАБИНЕТ: БОКОВАЯ НАВИГАЦИЯ --}}
        {{-- ========================================= --}}

        <flux:sidebar
            sticky
            collapsible="mobile"
            class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900"
        >

            <flux:sidebar.header>

                <flux:sidebar.brand
                    href="{{ route('dashboard') }}"
                    name="Семейный кабинет"
                />

                <flux:sidebar.collapse class="lg:hidden" />

            </flux:sidebar.header>

            <flux:sidebar.nav>

                <flux:sidebar.item
                    icon="home"
                    href="{{ route('dashboard') }}"
                    :current="request()->routeIs('dashboard')"
                >
                    Главная
                </flux:sidebar.item>

                <flux:sidebar.item
                    icon="cog-6-tooth"
                    href="#"
                >
                    Настройки
                </flux:sidebar.item>

            </flux:sidebar.nav>

            <flux:sidebar.spacer />

            {{-- Выход из личного кабинета --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <flux:button
                    type="submit"
                    variant="ghost"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full"
                >
                    Выйти
                </flux:button>
            </form>

        </flux:sidebar>


        {{-- ========================================= --}}
        {{-- ЛИЧНЫЙ КАБИНЕТ: ВЕРХНЯЯ ПАНЕЛЬ --}}
        {{-- ========================================= --}}

        <flux:header class="border-b border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">

            {{-- Бургер для мобильных устройств и планшетов --}}
            <flux:sidebar.toggle
                class="lg:hidden"
                icon="bars-2"
                inset="left"
            />

            {{-- Название приложения на больших экранах --}}
            <flux:brand
                href="{{ route('dashboard') }}"
                name="Семейный кабинет"
                class="max-lg:hidden"
            />

            <flux:spacer />

            {{-- Профиль пользователя --}}
            <flux:dropdown position="top" align="end">

                <flux:profile :name="auth()->user()->name" />

                <flux:menu>

                    <div class="px-3 py-2">

                        <flux:text size="sm">
                            Вы вошли как
                        </flux:text>

                        <flux:heading size="sm" class="mt-1">
                            {{ auth()->user()->email }}
                        </flux:heading>

                    </div>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                        >
                            Выйти
                        </flux:menu.item>
                    </form>

                </flux:menu>

            </flux:dropdown>

        </flux:header>


        {{-- ========================================= --}}
        {{-- СОДЕРЖИМОЕ ЛИЧНОГО КАБИНЕТА --}}
        {{-- ========================================= --}}

        <flux:main container>
            {{ $slot }}
        </flux:main>


    @else


        {{-- ========================================= --}}
        {{-- ПУБЛИЧНАЯ ЧАСТЬ: МОБИЛЬНАЯ НАВИГАЦИЯ --}}
        {{-- ========================================= --}}

        <flux:sidebar
            sticky
            collapsible="mobile"
            class="border-r border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 lg:hidden"
        >

            <flux:sidebar.header>

                <flux:sidebar.brand
                    href="{{ route('home') }}"
                    name="Семейный кабинет"
                />

                <flux:sidebar.collapse class="lg:hidden" />

            </flux:sidebar.header>

            <flux:sidebar.nav>

                <flux:sidebar.item
                    icon="home"
                    href="{{ route('home') }}"
                >
                    Главная
                </flux:sidebar.item>

                <flux:sidebar.item
                    icon="squares-2x2"
                    href="{{ route('home') }}#features"
                >
                    Возможности
                </flux:sidebar.item>

            </flux:sidebar.nav>

            <flux:sidebar.spacer />

            <flux:sidebar.nav>

                {{-- Вход без дополнительной иконки --}}
                <flux:sidebar.item href="{{ route('login') }}">
                    Войти
                </flux:sidebar.item>

            </flux:sidebar.nav>

            <div class="mt-auto p-4">

                <flux:button
                    href="{{ route('register') }}"
                    variant="primary"
                    icon="user-plus"
                    class="w-full"
                >
                    Создать аккаунт
                </flux:button>

            </div>

        </flux:sidebar>


        {{-- ========================================= --}}
        {{-- ПУБЛИЧНАЯ ЧАСТЬ: ВЕРХНЯЯ ПАНЕЛЬ --}}
        {{-- ========================================= --}}

        <flux:header class="border-b border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">

            {{-- Бургер для мобильных устройств и планшетов --}}
            <flux:sidebar.toggle
                class="lg:hidden"
                icon="bars-2"
                inset="left"
            />

            <flux:brand
                href="{{ route('home') }}"
                name="Семейный кабинет"
            />

            {{-- Горизонтальная навигация на компьютерах --}}
            <flux:navbar class="max-lg:hidden">

                <flux:navbar.item
                    icon="home"
                    href="{{ route('home') }}"
                >
                    Главная
                </flux:navbar.item>

                <flux:navbar.item
                    icon="squares-2x2"
                    href="{{ route('home') }}#features"
                >
                    Возможности
                </flux:navbar.item>

            </flux:navbar>

            <flux:spacer />

            {{-- Кнопки для компьютеров --}}
            <div class="hidden items-center gap-2 lg:flex">

                <flux:button
                    href="{{ route('login') }}"
                    variant="ghost"
                    size="sm"
                >
                    Войти
                </flux:button>

                <flux:button
                    href="{{ route('register') }}"
                    variant="primary"
                    icon="user-plus"
                    size="sm"
                >
                    Создать аккаунт
                </flux:button>

            </div>

        </flux:header>


        {{-- ========================================= --}}
        {{-- СОДЕРЖИМОЕ ПУБЛИЧНОЙ СТРАНИЦЫ --}}
        {{-- ========================================= --}}

        <main>
            {{ $slot }}
        </main>

    @endauth


    @livewireScripts
    @fluxScripts

</body>
</html>
