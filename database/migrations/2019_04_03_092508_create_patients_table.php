<?php
// database/migrations/2024_01_01_000002_create_patients_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->text('allergies')->nullable();
            $table->text('chronic_diseases')->nullable();
            $table->text('current_medications')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relation')->nullable();
            $table->string('insurance_policy_number')->nullable();
            $table->string('insurance_company')->nullable();
            $table->date('insurance_valid_until')->nullable();
            $table->decimal('height', 5, 2)->nullable(); // в см
            $table->decimal('weight', 5, 2)->nullable(); // в кг
            $table->timestamps();
            
            // Индексы
            $table->index('user_id');
            $table->index('blood_type');
            $table->index('insurance_policy_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};