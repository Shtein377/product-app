<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $acceptedTerms = false;

    public function register()
    {
        $validated = $this->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'acceptedTerms' => ['accepted'],
            ],
            [
                'name.required' => 'Укажите ваше имя.',
                'name.max' => 'Имя не должно превышать 255 символов.',
                'email.required' => 'Укажите адрес электронной почты.',
                'email.email' => 'Введите корректный адрес электронной почты.',
                'email.unique' => 'Пользователь с таким email уже зарегистрирован.',
                'password.required' => 'Придумайте пароль.',
                'password.min' => 'Пароль должен содержать не менее 8 символов.',
                'password.confirmed' => 'Пароли не совпадают.',
                'acceptedTerms.accepted' => 'Необходимо согласиться с условиями обработки персональных данных.',
            ],
        );

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        Auth::login($user);

        request()->session()->regenerate();

        return $this->redirect('/dashboard');
    }
};
?>

<div class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md space-y-6">

        <div class="text-center space-y-2">
            <flux:heading size="xl">
                Создать аккаунт
            </flux:heading>

            <flux:text>
                Зарегистрируйтесь, чтобы вести семейный кабинет ребёнка
            </flux:text>
        </div>

        <form wire:submit="register" class="space-y-5">

            <flux:input wire:model="name" label="Ваше имя" placeholder="Например, Анна" autocomplete="name" autofocus />

            <flux:input wire:model="email" type="email" label="Электронная почта" placeholder="example@mail.ru"
                autocomplete="email" />

            <flux:input wire:model="password" type="password" label="Пароль" placeholder="Не менее 8 символов"
                autocomplete="new-password" viewable />

            <flux:input wire:model="password_confirmation" type="password" label="Повторите пароль"
                placeholder="Введите пароль ещё раз" autocomplete="new-password" viewable />

            <flux:field variant="inline">
                <flux:checkbox wire:model="acceptedTerms" />

                <flux:label>
                    <a href="/privacy">Я согласен(на) с

                        политикой конфиденциальности

                        и обработкой персональных данных. </a>
                </flux:label>

                <flux:error name="acceptedTerms" />
            </flux:field>

            <flux:button type="submit" variant="primary" class="w-full" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="register">
                    Зарегистрироваться
                </span>

                <span wire:loading wire:target="register">
                    Создаём аккаунт...
                </span>
            </flux:button>

        </form>

        <div class="text-center">
            <flux:text>
                Уже есть аккаунт?
                <a href="/login" class="font-medium underline">
                    Войти
                </a>
            </flux:text>
        </div>

    </div>
</div>
