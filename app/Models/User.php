<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'phone',
        'password',
        'full_name',
        'date_of_birth',
        'gender',
        'user_type',
        'avatar',
        'address',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    // ========== СВЯЗИ ==========

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function consultationsAsPatient()
    {
        return $this->hasMany(Consultation::class, 'patient_id');
    }

    public function consultationsAsDoctor()
    {
        return $this->hasMany(Consultation::class, 'doctor_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'patient_id');
    }

    public function uploadedFiles()
    {
        return $this->hasMany(MedicalFile::class, 'uploaded_by');
    }

    public function verifiedFiles()
    {
        return $this->hasMany(MedicalFile::class, 'verified_by');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }
}