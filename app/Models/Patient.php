<?php
// app/Models/Patient.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'user_id',
        'blood_type',
        'allergies',
        'chronic_diseases',
        'current_medications',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
        'insurance_policy_number',
        'insurance_company',
        'insurance_valid_until',
        'height',
        'weight',
    ];

    protected $casts = [
        'insurance_valid_until' => 'date',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'allergies' => 'array',
        'chronic_diseases' => 'array',
        'current_medications' => 'array',
    ];

    // ========== СВЯЗИ ==========

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function medicalFiles()
    {
        return $this->hasMany(MedicalFile::class);
    }

    public function bookedSlots()
    {
        return $this->hasMany(AvailableSlot::class, 'booked_by');
    }
}