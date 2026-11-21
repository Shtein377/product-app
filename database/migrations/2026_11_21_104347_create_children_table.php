<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();

            // Основная информация
            $table->string('name', 100);
            $table->date('birth_date');
            $table->string('gender', 10);

            // Данные при рождении
            $table->unsignedSmallInteger('birth_weight_g')->nullable();
            $table->decimal('birth_height_cm', 4, 1)->nullable();
            $table->unsignedTinyInteger('gestation_weeks')->nullable();

            // Медицинская информация
            $table->string('blood_type', 2)->nullable();
            $table->string('rh_factor', 8)->nullable();
            $table->text('allergies')->nullable();
            $table->text('notes')->nullable();

            // Основная фотография профиля
            $table->string('avatar_path')->nullable();

            // Системные поля
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
