<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Carbon\Carbon;

new class extends Component
{
    private const TIMEZONES = [
        'Europe/Kaliningrad' => [
            'Калининград',
        ],
        'Europe/Moscow' => [
            'Москва',
            'Санкт-Петербург',
            'Нижний Новгород',
            'Казань',
            'Ростов-на-Дону',
            'Краснодар',
            'Воронеж',
        ],
        'Europe/Samara' => [
            'Самара',
            'Саратов',
            'Ульяновск',
            'Ижевск',
        ],
        'Asia/Yekaterinburg' => [
            'Екатеринбург',
            'Пермь',
            'Уфа',
            'Челябинск',
            'Тюмень',
        ],
        'Asia/Omsk' => [
            'Омск',
        ],
        'Asia/Novosibirsk' => [
            'Новосибирск',
            'Барнаул',
            'Томск',
            'Кемерово',
            'Новокузнецк',
        ],
        'Asia/Krasnoyarsk' => [
            'Красноярск',
            'Абакан',
            'Норильск',
        ],
        'Asia/Irkutsk' => [
            'Иркутск',
            'Улан-Удэ',
        ],
        'Asia/Chita' => [
            'Чита',
        ],
        'Asia/Yakutsk' => [
            'Якутск',
            'Благовещенск',
        ],
        'Asia/Vladivostok' => [
            'Владивосток',
            'Хабаровск',
        ],
        'Asia/Sakhalin' => [
            'Южно-Сахалинск',
        ],
        'Asia/Magadan' => [
            'Магадан',
        ],
        'Asia/Kamchatka' => [
            'Петропавловск-Камчатский',
            'Анадырь',
        ],
    ];

    public string $name = '';

    public string $timezone = 'Europe/Moscow';

    public string $timezoneSearch = '';

    public bool $timezoneDropdownOpen = false;

    public bool $notify_email = true;

    public bool $notify_max = false;

    public bool $saved = false;

    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->timezone = $user->timezone;
        $this->notify_email = $user->notify_email;
        $this->notify_max = $user->notify_max;
    }

    public function save(): void
    {
        $validated = $this->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'timezone' => ['required', 'timezone'],
                'notify_email' => ['required', 'boolean'],
                'notify_max' => ['required', 'boolean'],
            ],
            [
                'name.required' => 'Укажите ваше имя.',
                'name.max' => 'Имя не должно превышать 255 символов.',
                'timezone.required' => 'Выберите часовой пояс.',
                'timezone.timezone' => 'Выбран некорректный часовой пояс.',
            ]
        );

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update($validated);

        $this->saved = true;
    }

    public function toggleTimezoneDropdown(): void
    {
        $this->timezoneDropdownOpen = ! $this->timezoneDropdownOpen;

        $this->timezoneSearch = '';
    }

    public function closeTimezoneDropdown(): void
    {
        $this->timezoneDropdownOpen = false;
        $this->timezoneSearch = '';
    }

    public function selectTimezone(string $identifier): void
    {
        if (! array_key_exists($identifier, self::TIMEZONES)) {
            return;
        }

        $this->timezone = $identifier;
        $this->timezoneDropdownOpen = false;
        $this->timezoneSearch = '';
        $this->saved = false;
    }

   private function getUtcOffset(string $identifier): string
{
    return 'UTC' . Carbon::now($identifier)->format('P');
}

    #[Computed]
    public function filteredTimezones(): array
    {
        $search = mb_strtolower(trim($this->timezoneSearch));

        $results = [];

        foreach (self::TIMEZONES as $identifier => $cities) {
            foreach ($cities as $city) {
                if (
                    $search !== ''
                    && ! str_contains(mb_strtolower($city), $search)
                    && ! str_contains(mb_strtolower($identifier), $search)
                ) {
                    continue;
                }

                $results[] = [
                    'timezone' => $identifier,
                    'city' => $city,
                    'offset' => $this->getUtcOffset($identifier),
                ];
            }
        }

        return $results;
    }

    #[Computed]
    public function selectedTimezoneLabel(): string
    {
        foreach (self::TIMEZONES as $identifier => $cities) {
            if ($identifier === $this->timezone) {
                return $cities[0] . ' (' . $this->getUtcOffset($identifier) . ')';
            }
        }

        return $this->timezone;
    }
};
?>

<div class="min-h-screen p-6">
    <div class="mx-auto max-w-5xl space-y-8">

        {{-- Заголовок --}}
        <section class="space-y-2">
            <flux:heading size="xl">
                Настройки профиля
            </flux:heading>

            <flux:text>
                Управляйте личными данными и настройками уведомлений.
            </flux:text>
        </section>

        <flux:card class="space-y-6">

            <form wire:submit="save" class="space-y-6">

                {{-- Имя --}}
                <flux:field>
                    <flux:label>Ваше имя</flux:label>

                    <flux:input
                        wire:model="name"
                        placeholder="Введите ваше имя" />

                    <flux:error name="name" />
                </flux:field>

                {{-- Часовой пояс --}}
                <flux:field>
                    <flux:label>Часовой пояс</flux:label>

                    <div
                        class="relative"
                        wire:click.outside="closeTimezoneDropdown"
                        wire:keydown.escape="closeTimezoneDropdown">
                        {{-- Кнопка открытия списка --}}
                        <button
                            type="button"
                            wire:click="toggleTimezoneDropdown"
                            aria-expanded="{{ $timezoneDropdownOpen ? 'true' : 'false' }}"
                            class="flex w-full items-center justify-between gap-3 rounded-lg border border-zinc-300 bg-white px-3 py-2.5 text-left text-sm shadow-sm transition hover:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-900">
                            <span>{{ $this->selectedTimezoneLabel }}</span>

                            <flux:icon.chevron-down
                                class="size-4 shrink-0 text-zinc-500" />
                        </button>

                        {{-- Выпадающий список --}}
                        @if ($timezoneDropdownOpen)
                        <div
                            class="absolute left-0 right-0 top-full z-50 mt-2 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                            {{-- Поиск --}}
                            <div class="sticky top-0 border-b border-zinc-200 bg-white p-3 dark:border-zinc-700 dark:bg-zinc-900">
                                <flux:input
                                    wire:model.live.debounce.250ms="timezoneSearch"
                                    type="search"
                                    placeholder="Начните вводить название города..."
                                    icon="magnifying-glass"
                                    autofocus />
                            </div>

                            {{-- Результаты --}}
                            <div class="max-h-64 overflow-y-auto p-1">

                                @forelse ($this->filteredTimezones as $timezoneOption)
                                <button
                                    type="button"
                                    wire:key="timezone-{{ $timezoneOption['city'] }}"
                                    wire:click="selectTimezone('{{ $timezoneOption['timezone'] }}')"
                                    class="flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-left text-sm transition hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ $timezone === $timezoneOption['timezone'] ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'text-zinc-700 dark:text-zinc-200' }}">
                                    <span>{{ $timezoneOption['city'] }}</span>

                                    <span class="flex shrink-0 items-center gap-2">
                                        <span class="text-xs text-zinc-500">
                                            {{ $timezoneOption['offset'] }}
                                        </span>

                                        @if ($timezone === $timezoneOption['timezone'])
                                        <flux:icon.check class="size-4" />
                                        @endif
                                    </span>
                                </button>
                                @empty
                                <div class="px-3 py-6 text-center text-sm text-zinc-500">
                                    Город не найден. Попробуйте изменить запрос.
                                </div>
                                @endforelse

                            </div>
                        </div>
                        @endif
                    </div>

                    <flux:error name="timezone" />

                    <flux:description>
                        Выберите город, чтобы установить часовой пояс для дат и напоминаний.
                    </flux:description>
                </flux:field>

                {{-- Уведомления --}}
                <div class="space-y-4">
                    <flux:heading size="lg">
                        Уведомления
                    </flux:heading>

                    <flux:checkbox
                        wire:model="notify_email"
                        label="Получать уведомления по электронной почте" />

                    <flux:checkbox
                        wire:model="notify_max"
                        label="Получать уведомления через MAX" />

                    <flux:text class="text-sm text-zinc-500">
                        Уведомления MAX будут доступны после подключения аккаунта.
                    </flux:text>
                </div>

                {{-- Сообщение об успешном сохранении --}}
                @if ($saved)
                <flux:text class="text-sm text-green-600 dark:text-green-400">
                    Настройки успешно сохранены.
                </flux:text>
                @endif

                {{-- Кнопка сохранения --}}
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary">
                        Сохранить настройки
                    </flux:button>
                </div>

            </form>

        </flux:card>

    </div>
</div>