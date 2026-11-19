<?php
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    public string $email = '';

    public string $password = '';

    public function mount(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }
    }

    public function login(): void
    {
        $validated = $this->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ],
            [
                'email.required' => 'Введите адрес электронной почты.',
                'email.email' => 'Введите корректный адрес электронной почты.',
                'password.required' => 'Введите пароль.',
            ],
        );

        if (!Auth::attempt($validated)) {
            $this->addError('email', 'Неверный email или пароль.');

            return;
        }

        request()->session()->regenerate();

        $this->redirect('/dashboard');
    }
};
?>

<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-6 py-12">

    <div class="w-full max-w-md space-y-8">

        {{-- Заголовок --}}
        <div class="text-center space-y-3">

            <div
                class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                <flux:icon.heart class="size-8" />
            </div>

            <flux:heading size="2xl">
                С возвращением!
            </flux:heading>

            <flux:text class="text-zinc-500">
                Войдите в свой семейный кабинет
            </flux:text>

        </div>

        {{-- Форма входа --}}
        <flux:card class="space-y-6">

            <form wire:submit="login" class="space-y-5">

                {{-- Email --}}
                <flux:field>
                    <flux:label>Email</flux:label>

                    <flux:input wire:model="email" type="email" placeholder="name@example.com" autocomplete="email"
                        autofocus />

                    <flux:error name="email" />
                </flux:field>

                {{-- Пароль --}}
                <flux:field>
                    <flux:label>Пароль</flux:label>

                    <flux:input wire:model="password" type="password" placeholder="Введите пароль"
                        autocomplete="current-password" viewable />

                    <flux:error name="password" />
                </flux:field>

                {{-- Восстановление пароля --}}
                <div class="flex justify-end">
                    <a href="{{ route('password.request') }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        Забыли пароль?
                    </a>
                </div>

                {{-- Кнопка --}}
                <flux:button type="submit" variant="primary" class="w-full">
                    Войти
                </flux:button>

            </form>


            {{-- Разделитель --}}
            <div class="relative flex items-center">
                <div class="flex-grow border-t border-zinc-200 dark:border-zinc-700"></div>
                <span class="mx-4 text-sm text-zinc-400">или</span>
                <div class="flex-grow border-t border-zinc-200 dark:border-zinc-700"></div>
            </div>

            {{-- Вход через VK ID --}}
            <button type="button"
                class="flex w-full items-center justify-center gap-3 rounded-lg bg-[#0077FF] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0066DD]">
                <span
                    class="flex size-7 items-center justify-center rounded-md bg-white text-lg font-bold text-[#0077FF]">
                    vk
                </span>

                Продолжить через VK ID
            </button>
        </flux:card>

        {{-- Регистрация --}}
        <div class="text-center">
            <flux:text>
                Ещё нет аккаунта?
                <a href="{{ route('register') }}"
                    class="font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    Создать аккаунт
                </a>
            </flux:text>
        </div>

        {{-- Возврат на главную --}}
        <div class="text-center">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200">
                <flux:icon.arrow-left class="size-4" />
                На главную
            </a>
        </div>

    </div>

</div>
