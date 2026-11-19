
<?php

use Illuminate\Support\Facades\Password;
use Livewire\Component;

new class extends Component
{
    public string $email = '';

    public string $statusMessage = '';

    public function sendResetLink(): void
    {
        $validated = $this->validate(
            [
                'email' => ['required', 'email'],
            ],
            [
                'email.required' => 'Введите адрес электронной почты.',
                'email.email' => 'Введите корректный адрес электронной почты.',
            ]
        );

        $status = Password::sendResetLink($validated);

        if ($status === Password::ResetLinkSent) {
            $this->statusMessage = 'Если аккаунт с таким адресом существует, на него будет отправлена ссылка для восстановления пароля.';

            return;
        }

        $this->addError(
            'email',
            'Не удалось отправить ссылку. Проверьте адрес или попробуйте позже.'
        );
    }
};
?>

<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-md space-y-8">

        <div class="text-center space-y-3">
            <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                <flux:icon.lock-open class="size-8" />
            </div>

            <flux:heading size="2xl">
                Восстановление пароля
            </flux:heading>

            <flux:text class="text-zinc-500">
                Укажите email, который использовали при регистрации.
                Мы отправим вам ссылку для создания нового пароля.
            </flux:text>
        </div>

        <flux:card class="space-y-6">

            @if ($statusMessage)
                <flux:text class="text-sm text-green-600 dark:text-green-400">
                    {{ $statusMessage }}
                </flux:text>
            @endif

            <form wire:submit="sendResetLink" class="space-y-5">

                <flux:field>
                    <flux:label>Email</flux:label>

                    <flux:input
                        wire:model="email"
                        type="email"
                        placeholder="name@example.com"
                        autocomplete="email"
                        autofocus
                    />

                    <flux:error name="email" />
                </flux:field>

                <flux:button type="submit" variant="primary" class="w-full">
                    Отправить ссылку
                </flux:button>

            </form>

        </flux:card>

        <div class="text-center">
            <a
                href="{{ route('login') }}"
                class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200"
            >
                <flux:icon.arrow-left class="size-4" />
                Вернуться ко входу
            </a>
        </div>

    </div>
</div>
