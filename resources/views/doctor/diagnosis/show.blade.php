@extends('layouts.app')

@section('title', 'Просмотр диагноза')

@section('content')
<div style="max-width: 800px; margin: 80px auto 40px; padding: 0 20px;">
    <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden;">
        
        <div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 25px 30px; color: white;">
            <a href="{{ route('doctor.diagnosis.index') }}" style="color: #94a3b8; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
            <h1 style="font-size: 24px; margin: 0;">
                <i class="fas fa-file-medical"></i> Просмотр диагноза
            </h1>
        </div>
        
        <div style="padding: 30px;">
            <!-- Пациент -->
            <div style="background: #f8fafc; padding: 20px; border-radius: 16px; margin-bottom: 25px;">
                <h3 style="margin-bottom: 15px;"><i class="fas fa-user"></i> Пациент</h3>
                <p><strong>ФИО:</strong> {{ $consultation->patient->user->full_name ?? '—' }}</p>
                <p><strong>Телефон:</strong> {{ $consultation->patient->user->phone ?? '—' }}</p>
                <p><strong>Email:</strong> {{ $consultation->patient->user->email ?? '—' }}</p>
            </div>
            
            <!-- Жалобы -->
            @if($consultation->symptoms)
            <div style="background: #fef3c7; padding: 20px; border-radius: 16px; margin-bottom: 25px;">
                <h3 style="margin-bottom: 15px;"><i class="fas fa-notes-medical"></i> Жалобы пациента</h3>
                <p style="margin: 0;">{{ $consultation->symptoms }}</p>
            </div>
            @endif
            
            <!-- Диагноз -->
            <div style="background: #dbeafe; padding: 20px; border-radius: 16px; margin-bottom: 25px;">
                <h3 style="margin-bottom: 15px;"><i class="fas fa-diagnoses"></i> Диагноз</h3>
                <p style="margin: 0; font-size: 16px;">{{ $consultation->diagnosis }}</p>
            </div>
            
            <!-- Заметки врача -->
            @if($consultation->doctor_notes)
            <div style="background: #e8f5f0; padding: 20px; border-radius: 16px; margin-bottom: 25px;">
                <h3 style="margin-bottom: 15px;"><i class="fas fa-sticky-note"></i> Заметки / Рекомендации</h3>
                <p style="margin: 0; white-space: pre-wrap;">{{ $consultation->doctor_notes }}</p>
            </div>
            @endif
            
            <!-- Дополнительная информация -->
            <div style="background: #f8fafc; padding: 20px; border-radius: 16px;">
                <h3 style="margin-bottom: 15px;"><i class="fas fa-info-circle"></i> Дополнительная информация</h3>
                <p><strong>Статус:</strong> 
                    @if($consultation->status == 'completed')
                        <span style="color: #10b981;">Завершена</span>
                    @elseif($consultation->status == 'in_progress')
                        <span style="color: #f59e0b;">В процессе</span>
                    @else
                        {{ $consultation->status }}
                    @endif
                </p>
                <p><strong>Дата создания:</strong> {{ $consultation->created_at->format('d.m.Y H:i') }}</p>
                @if($consultation->ended_at)
                <p><strong>Дата завершения:</strong> {{ \Carbon\Carbon::parse($consultation->ended_at)->format('d.m.Y H:i') }}</p>
                @endif
            </div>
            
            <div style="margin-top: 30px; display: flex; gap: 15px;">
                <a href="{{ route('doctor.diagnosis.edit', $consultation->id) }}" 
                    style="background: #f59e0b; color: white; padding: 12px 30px; border-radius: 12px; text-decoration: none;">
                    <i class="fas fa-edit"></i> Редактировать
                </a>
                <a href="{{ route('doctor.diagnosis.index') }}" 
                    style="background: #64748b; color: white; padding: 12px 30px; border-radius: 12px; text-decoration: none;">
                    <i class="fas fa-list"></i> К списку
                </a>
            </div>
        </div>
    </div>
</div>
@endsection