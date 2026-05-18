<?php
// app/Models/Prescription.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescriptions';

    protected $fillable = [
        'consultation_id',
        'doctor_id',
        'patient_id',
        'prescription_number',
        'medication_name',
        'dosage',
        'frequency',
        'duration',
        'quantity',
        'instructions',
        'side_effects',
        'valid_from',
        'valid_until',
        'is_digital_signature',
        'signature_hash',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_digital_signature' => 'boolean',
        'quantity' => 'integer',
    ];

    // ========== СВЯЗИ ==========

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicalFiles()
    {
        return $this->hasMany(MedicalFile::class);
    }
}