<?php
// app/Models/DoctorSchedule.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $table = 'doctor_schedules';

    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration_minutes',
        'break_between_slots_minutes',
        'lunch_break_start',
        'lunch_break_end',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'lunch_break_start' => 'datetime:H:i',
        'lunch_break_end' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    // ========== СВЯЗИ ==========

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function availableSlots()
    {
        return $this->hasMany(AvailableSlot::class);
    }
}