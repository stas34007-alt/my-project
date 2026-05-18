<?php
// database/migrations/2024_01_01_000009_create_medical_files_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users');
            $table->foreignId('consultation_id')->nullable()->constrained('consultations')->onDelete('set null');
            $table->foreignId('prescription_id')->nullable()->constrained('prescriptions')->onDelete('set null');
            $table->string('file_name');
            $table->string('file_original_name');
            $table->string('file_path');
            $table->string('file_size')->nullable(); // в байтах
            $table->string('mime_type')->nullable();
            $table->enum('file_category', [
                'lab_result', 
                'radiology', 
                'prescription', 
                'medical_history',
                'discharge_summary',
                'referral',
                'other'
            ])->default('other');
            $table->text('description')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamps();
            
            // Индексы
            $table->index('patient_id');
            $table->index('uploaded_by');
            $table->index('consultation_id');
            $table->index('prescription_id');
            $table->index('file_category');
            $table->index('is_verified');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_files');
    }
};