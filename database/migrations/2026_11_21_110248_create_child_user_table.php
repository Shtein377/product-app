
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_user', function (Blueprint $table) {
            $table->id();

            // Связь с ребёнком
            $table->foreignId('child_id')
                ->constrained('children')
                ->cascadeOnDelete();

            // Связь с пользователем
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Роль пользователя
            $table->string('role', 10)->default('parent');

            $table->timestamps();

            // Один пользователь не может быть подключён
            // к одному ребёнку несколько раз
            $table->unique(['child_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_user');
    }
};
