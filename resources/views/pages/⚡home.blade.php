
<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    {{-- Главный экран --}}
    <section class="relative overflow-hidden bg-white dark:bg-zinc-900">
        <div class="mx-auto max-w-7xl px-6 py-20 lg:py-28">

            <div class="grid items-center gap-12 lg:grid-cols-2">

                <div class="max-w-xl space-y-7">

                    <flux:badge color="blue" icon="heart">
                        Пространство заботы о ребёнке
                    </flux:badge>

                    <flux:heading size="2xl" level="1">
                        Всё важное о здоровье и развитии ребёнка — в одном месте
                    </flux:heading>

                    <flux:text class="text-base leading-relaxed">
                        Семейный кабинет поможет сохранять важную информацию
                        о ребёнке, следить за его развитием, планировать
                        визиты к врачам и не забывать о важных событиях.
                    </flux:text>

                    <div class="flex flex-wrap gap-3">
                        <flux:button
                            href="{{ route('register') }}"
                            variant="primary"
                            icon="user-plus"
                        >
                            Создать аккаунт
                        </flux:button>
                    </div>

                    <flux:text size="sm" class="text-zinc-500">
                        Ваш семейный помощник — от первых дней жизни
                        до взросления.
                    </flux:text>

                </div>

                {{-- Визуальный блок семейного кабинета --}}
                <div class="relative">
                    <div class="rounded-3xl bg-blue-50 p-8 dark:bg-zinc-800">

                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <flux:heading size="lg">
                                    Семейный кабинет
                                </flux:heading>

                                <flux:text size="sm">
                                    Всё самое важное рядом
                                </flux:text>
                            </div>

                            <div class="flex size-12 items-center justify-center rounded-2xl bg-white text-blue-600 dark:bg-zinc-700">
                                <flux:icon.heart class="size-8" />
                            </div>
                        </div>

                        <div class="space-y-3">

                            {{-- Профили детей --}}
                            <div class="flex items-center gap-4 rounded-xl bg-white p-4 dark:bg-zinc-700">
                                <div class="flex size-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                    <flux:icon.users class="size-6" />
                                </div>

                                <div class="flex-1">
                                    <flux:heading size="sm">
                                        Профили детей
                                    </flux:heading>

                                    <flux:text size="xs">
                                        Важная информация в одном месте
                                    </flux:text>
                                </div>

                                <flux:icon.chevron-right class="size-5 text-zinc-400" />
                            </div>

                            {{-- Рост и развитие --}}
                            <div class="flex items-center gap-4 rounded-xl bg-white p-4 dark:bg-zinc-700">
                                <div class="flex size-11 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                    <flux:icon.chart-bar class="size-6" />
                                </div>

                                <div class="flex-1">
                                    <flux:heading size="sm">
                                        Рост и развитие
                                    </flux:heading>

                                    <flux:text size="xs">
                                        История изменений и наблюдений
                                    </flux:text>
                                </div>

                                <flux:icon.chevron-right class="size-5 text-zinc-400" />
                            </div>

                            {{-- Прививки и врачи --}}
                            <div class="flex items-center gap-4 rounded-xl bg-white p-4 dark:bg-zinc-700">
                                <div class="flex size-11 items-center justify-center rounded-xl bg-violet-100 text-violet-700">
                                    <flux:icon.clipboard-document-list class="size-6" />
                                </div>

                                <div class="flex-1">
                                    <flux:heading size="sm">
                                        Прививки и врачи
                                    </flux:heading>

                                    <flux:text size="xs">
                                        История и важные даты
                                    </flux:text>
                                </div>

                                <flux:icon.chevron-right class="size-5 text-zinc-400" />
                            </div>

                            {{-- Напоминания --}}
                            <div class="flex items-center gap-4 rounded-xl bg-white p-4 dark:bg-zinc-700">
                                <div class="flex size-11 items-center justify-center rounded-xl bg-rose-100 text-rose-700">
                                    <flux:icon.bell class="size-6" />
                                </div>

                                <div class="flex-1">
                                    <flux:heading size="sm">
                                        Напоминания
                                    </flux:heading>

                                    <flux:text size="xs">
                                        Чтобы ничего важного не забыть
                                    </flux:text>
                                </div>

                                <flux:icon.chevron-right class="size-5 text-zinc-400" />
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Возможности --}}
    <section
        id="features"
        class="border-t border-zinc-200 bg-zinc-50 py-16 dark:border-zinc-800 dark:bg-zinc-950"
    >
        <div class="mx-auto max-w-7xl px-6">

            <div class="mx-auto mb-10 max-w-2xl space-y-3 text-center">
                <flux:heading size="xl" level="2">
                    Забота складывается из мелочей
                </flux:heading>

                <flux:text class="text-base">
                    В процессе взросления ребёнка накапливается много
                    важных сведений. Мы хотим помочь родителям
                    хранить их удобно и последовательно.
                </flux:text>
            </div>

            <div class="grid gap-5 md:grid-cols-3">

                <flux:card class="space-y-3">
                    <flux:icon.chart-bar class="size-8 text-blue-600" />

                    <flux:heading size="lg">
                        Следите за развитием
                    </flux:heading>

                    <flux:text>
                        Сохраняйте показатели роста и веса,
                        наблюдайте за изменениями и историей развития.
                    </flux:text>
                </flux:card>

                <flux:card class="space-y-3">
                    <flux:icon.heart class="size-8 text-rose-600" />

                    <flux:heading size="lg">
                        Храните историю здоровья
                    </flux:heading>

                    <flux:text>
                        Собирайте сведения о прививках,
                        посещениях врачей и важных событиях.
                    </flux:text>
                </flux:card>

                <flux:card class="space-y-3">
                    <flux:icon.bell class="size-8 text-amber-600" />

                    <flux:heading size="lg">
                        Помните о важном
                    </flux:heading>

                    <flux:text>
                        Используйте напоминания, чтобы
                        планировать предстоящие события и визиты.
                    </flux:text>
                </flux:card>

            </div>
        </div>
    </section>
</div>
