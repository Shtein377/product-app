<?php
use App\Models\User;
use Livewire\Component;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

new class extends Component
{
   public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

     public function resetPassword(): void
    {
        $validated = $this->validate(
            [
                'token' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'email.required' => 'Введите адрес электронной почты.',
                'email.email' => 'Введите корректный адрес электронной почты.',
                'password.required' => 'Введите новый пароль.',
                'password.min' => 'Пароль должен содержать не менее 8 символов.',
                'password.confirmed' => 'Пароли не совпадают.',
            ]
        );

        $status = Password::reset(
            $validated,
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => $password,
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PasswordReset) {
            $this->addError(
                'email',
                'Ссылка недействительна или срок её действия истёк. Запросите новую ссылку.'
            );

            return;
        }

        session()->flash(
            'status',
            'Пароль успешно изменён. Теперь вы можете войти в аккаунт.'
        );

        $this->redirectRoute('login');
    }
};
?>

<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-md space-y-8">

        <div class="text-center space-y-3">
            <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                <flux:icon.lock-closed class="size-8" />
            </div>

            <flux:heading size="2xl">
                Новый пароль
            </flux:heading>

            <flux:text class="text-zinc-500">
                Придумайте новый пароль для входа в семейный кабинет.
            </flux:text>
        </div>

        <flux:card class="space-y-6">

            <form wire:submit="resetPassword" class="space-y-5">

                <flux:field>
                    <flux:label>Email</flux:label>

                    <flux:input
                        wire:model="email"
                        type="email"
                        placeholder="name@example.com"
                        autocomplete="email"
                    />

                    <flux:error name="email" />
                </flux:field>

                <flux:field>
                    <flux:label>Новый пароль</flux:label>

                    <flux:input
                        wire:model="password"
                        type="password"
                        placeholder="Не менее 8 символов"
                        autocomplete="new-password"
                        viewable
                    />

                    <flux:error name="password" />
                </flux:field>

                <flux:field>
                    <flux:label>Повторите новый пароль</flux:label>

                    <flux:input
                        wire:model="password_confirmation"
                        type="password"
                        placeholder="Повторите пароль"
                        autocomplete="new-password"
                        viewable
                    />
                </flux:field>

                <flux:button type="submit" variant="primary" class="w-full">
                    Сохранить новый пароль
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