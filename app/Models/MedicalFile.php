<?php
// app/Models/MedicalFile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalFile extends Model
{
    use HasFactory;

    protected $table = 'medical_files';

    protected $fillable = [
        'patient_id',
        'uploaded_by',
        'consultation_id',
        'prescription_id',
        'file_name',
        'file_original_name',
        'file_path',
        'file_size',
        'mime_type',
        'file_category',
        'description',
        'is_verified',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'file_size' => 'integer',
    ];

    // ========== СВЯЗИ ==========

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}