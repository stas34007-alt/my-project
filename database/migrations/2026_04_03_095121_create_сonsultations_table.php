<?php
// database/migrations/2024_01_01_000006_create_consultations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('slot_id')->nullable()->constrained('available_slots')->onDelete('set null');
            $table->enum('type', ['video', 'chat', 'phone'])->default('video');
            $table->enum('status', [
                'scheduled', 
                'pending_payment', 
                'waiting_for_doctor', 
                'ongoing', 
                'completed', 
                'cancelled_by_patient', 
                'cancelled_by_doctor', 
                'no_show_patient', 
                'no_show_doctor',
                'refunded'
            ])->default('scheduled');
            $table->string('meeting_id')->nullable();
            $table->string('meeting_link')->nullable();
            $table->text('symptoms')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('doctor_notes')->nullable();
            $table->text('patient_notes')->nullable();
            $table->tinyInteger('rating')->nullable()->min(1)->max(5);
            $table->text('review')->nullable();
            $table->decimal('final_price', 10, 2)->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();
            
            // Индексы
            $table->index('patient_id');
            $table->index('doctor_id');
            $table->index('slot_id');
            $table->index('status');
            $table->index('type');
            $table->index('created_at');
            $table->index(['doctor_id', 'status']);
            $table->index(['patient_id', 'status']);
            $table->index('meeting_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};