<?php
// app/Models/AvailableSlot.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableSlot extends Model
{
    use HasFactory;

    protected $table = 'available_slots';

    protected $fillable = [
        'doctor_id',
        'slot_start',
        'slot_end',
        'is_booked',
        'booked_by',
        'booked_at',
    ];

    protected $casts = [
        'slot_start' => 'datetime',
        'slot_end' => 'datetime',
        'booked_at' => 'datetime',
        'is_booked' => 'boolean',
    ];

    // ========== СВЯЗИ ==========

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function bookedBy()
    {
        return $this->belongsTo(Patient::class, 'booked_by');
    }

    public function consultation()
    {
        return $this->hasOne(Consultation::class);
    }
}