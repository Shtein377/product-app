<?php

use Livewire\Component;
use Livewire\Attributes\Title;
new #[Title('Дашборд')] class extends Component

{
    //
};
?>

<div>
   <div>
        <flux:heading size="xl" level="1">Дашборд</flux:heading>
        <flux:subheading>Общая картина по всем вашим группам</flux:subheading>
    </div>

    <flux:text>Здесь появятся итоги: сколько вам должны и сколько должны вы.</flux:text>
</div>