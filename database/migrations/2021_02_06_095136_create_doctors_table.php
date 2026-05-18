<?php
// database/migrations/2024_01_01_000003_create_doctors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('specialization_id')->constrained('specializations')->onDelete('restrict');
            $table->string('slug')->unique();
            $table->string('license_number')->unique();
            $table->integer('years_of_experience')->nullable();
            $table->decimal('consultation_price', 10, 2)->default(0);
            $table->decimal('online_consultation_price', 10, 2)->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->text('education')->nullable();
            $table->text('work_experience')->nullable();
            $table->text('achievements')->nullable();
            $table->text('bio')->nullable();
            $table->json('languages')->nullable(); // языки, которыми владеет
            $table->json('certificates')->nullable(); // сертификаты
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_available_online')->default(true);
            $table->timestamps();
            
            // Индексы
            $table->index('user_id');
            $table->index('specialization_id');
            $table->index('slug');
            $table->index('license_number');
            $table->index('rating');
            $table->index('is_verified');
            $table->index('is_available_online');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};