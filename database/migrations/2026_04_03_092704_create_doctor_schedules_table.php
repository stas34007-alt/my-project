<?php
// database/migrations/2024_01_01_000004_create_doctor_schedules_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->tinyInteger('day_of_week'); // 1=понедельник, 7=воскресенье
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_duration_minutes')->default(30);
            $table->integer('break_between_slots_minutes')->default(0);
            $table->time('lunch_break_start')->nullable();
            $table->time('lunch_break_end')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Индексы
            $table->index(['doctor_id', 'day_of_week']);
            $table->index('is_active');
            
            // Уникальность: у одного врача не может быть двух расписаний на один день
            $table->unique(['doctor_id', 'day_of_week']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};