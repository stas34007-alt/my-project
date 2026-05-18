<?php
// app/Models/Consultation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $table = 'consultations';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'slot_id',
        'type',
        'status',
        'meeting_id',
        'meeting_link',
        'symptoms',
        'diagnosis',
        'doctor_notes',
        'patient_notes',
        'rating',
        'review',
        'final_price',
        'started_at',
        'ended_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'rating' => 'integer',
        'final_price' => 'decimal:2',
    ];

    // ========== СВЯЗИ ==========

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function slot()
    {
        return $this->belongsTo(AvailableSlot::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function medicalFiles()
    {
        return $this->hasMany(MedicalFile::class);
    }
}