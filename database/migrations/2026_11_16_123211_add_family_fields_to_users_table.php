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
        Schema::table('users', function (Blueprint $table) {
            $table->string('timezone', 50)
                ->default('Europe/Moscow');

            $table->boolean('notify_email')
                ->default(true);

            $table->boolean('notify_max')
                ->default(false);

            $table->string('max_user_id', 100)
                ->nullable()
                ->unique();

            $table->unsignedBigInteger('vk_id')
                ->nullable()
                ->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['max_user_id']);
            $table->dropUnique(['vk_id']);

            $table->dropColumn([
                'timezone',
                'notify_email',
                'notify_max',
                'max_user_id',
                'vk_id',
            ]);
        });
    }
};
