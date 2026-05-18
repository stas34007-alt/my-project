<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'consultation_id',
        'patient_id',
        'doctor_id',
        'payment_number',
        'amount',
        'commission_amount',
        'doctor_amount',
        'status',
        'payment_method',
        'payment_system',
        'transaction_id',
        'provider_transaction_id',
        'payment_details',
        'paid_at',
        'refunded_at',
        'refund_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'doctor_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
        'payment_details' => 'array',
    ];

    // ========== СВЯЗИ ==========

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}