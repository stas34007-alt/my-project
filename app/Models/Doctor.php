<?php
// app/Models/Doctor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [
        'user_id',
        'specialization_id',
        'slug',
        'license_number',
        'years_of_experience',
        'consultation_price',
        'online_consultation_price',
        'rating',
        'total_reviews',
        'education',
        'work_experience',
        'achievements',
        'bio',
        'languages',
        'certificates',
        'is_verified',
        'is_available_online',
    ];

    protected $casts = [
        'consultation_price' => 'decimal:2',
        'online_consultation_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_verified' => 'boolean',
        'is_available_online' => 'boolean',
        'languages' => 'array',
        'certificates' => 'array',
    ];

    // ========== СВЯЗИ ==========

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function availableSlots()
    {
        return $this->hasMany(AvailableSlot::class);
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
}