<?php
// database/migrations/2024_01_01_000007_create_prescriptions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->foreignId('patient_id')->constrained('patients');
            $table->string('prescription_number')->unique();
            $table->string('medication_name');
            $table->string('dosage')->nullable();
            $table->string('frequency')->nullable();
            $table->string('duration')->nullable();
            $table->integer('quantity')->nullable();
            $table->text('instructions')->nullable();
            $table->text('side_effects')->nullable();
            $table->date('valid_from')->default(now());
            $table->date('valid_until')->nullable();
            $table->boolean('is_digital_signature')->default(false);
            $table->string('signature_hash')->nullable();
            $table->timestamps();
            
            // Индексы
            $table->index('consultation_id');
            $table->index('doctor_id');
            $table->index('patient_id');
            $table->index('prescription_number');
            $table->index('valid_until');
            $table->index(['patient_id', 'valid_until']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};