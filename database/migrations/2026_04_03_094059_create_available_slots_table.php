<?php
// database/migrations/2024_01_01_000005_create_available_slots_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('available_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->dateTime('slot_start');
            $table->dateTime('slot_end');
            $table->boolean('is_booked')->default(false);
            $table->foreignId('booked_by')->nullable()->constrained('patients')->onDelete('set null');
            $table->timestamp('booked_at')->nullable();
            $table->timestamps();
            
            // Индексы
            $table->unique(['doctor_id', 'slot_start']);
            $table->index(['doctor_id', 'slot_start', 'is_booked']);
            $table->index('is_booked');
            $table->index('slot_start');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('available_slots');
    }
};