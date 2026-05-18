<?php
// database/migrations/2024_01_01_000008_create_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors');
            $table->string('payment_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->decimal('commission_amount', 10, 2)->default(0);
            $table->decimal('doctor_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'processing', 'paid', 'failed', 'refunded', 'chargeback'])->default('pending');
            $table->string('payment_method')->nullable(); // card, wallet, apple_pay, google_pay
            $table->string('payment_system')->nullable(); // stripe, paypal, yookassa
            $table->string('transaction_id')->nullable();
            $table->string('provider_transaction_id')->nullable();
            $table->json('payment_details')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->string('refund_reason')->nullable();
            $table->timestamps();
            
            // Индексы
            $table->index('consultation_id');
            $table->index('patient_id');
            $table->index('doctor_id');
            $table->index('status');
            $table->index('payment_number');
            $table->index('transaction_id');
            $table->index(['patient_id', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};