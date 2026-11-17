<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="min-h-screen p-6">
    <div class="mx-auto max-w-5xl space-y-6">

        <section class="space-y-2">
            <flux:heading size="xl">
                Добро пожаловать, {{ auth()->user()->name }}!
            </flux:heading>

            <flux:text>
                Здесь будет ваш семейный кабинет — пространство
                для заботы о здоровье и развитии детей.
            </flux:text>
        </section>

    </div>
</div>