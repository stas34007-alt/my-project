<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MedicalFileController extends Controller
{
    /**
     * Показать все консультации пользователя
     */
    public function index()
    {
        $user = Auth::user();
        
        // Получаем пациента по user_id
        $patient = $user->patient;
        
        if (!$patient) {
            return view('my-consultations', [
                'consultations' => collect([]),
                'message' => 'Вы не зарегистрированы как пациент'
            ]);
        }
        
        // Получаем все консультации пациента с связями
        $consultations = Consultation::where('patient_id', $patient->id)
            ->with(['doctor.user', 'doctor.specialization', 'slot'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Статистика
        $stats = [
            'total' => $consultations->count(),
            'scheduled' => $consultations->where('status', 'scheduled')->count(),
            'completed' => $consultations->where('status', 'completed')->count(),
            'cancelled' => $consultations->where('status', 'cancelled')->count(),
        ];
        
        return view('my-consultations', compact('consultations', 'stats'));
    }
    
    /**
     * Показать детали консультации
     */
    public function show($id)
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        $consultation = Consultation::where('id', $id)
            ->where('patient_id', $patient->id)
            ->with(['doctor.user', 'doctor.specialization', 'slot'])
            ->firstOrFail();
        
        return view('consultation-detail', compact('consultation'));
    }
    
    /**
     * Отменить консультацию
     */
    public function cancel(Request $request, $id)
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        $consultation = Consultation::where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();
        
        if ($consultation->status !== 'scheduled') {
            return response()->json([
                'success' => false,
                'message' => 'Эту консультацию нельзя отменить'
            ], 400);
        }
        
        $consultation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->reason
        ]);
        
        // Освобождаем слот
        if ($consultation->slot_id) {
            $consultation->slot->update([
                'is_booked' => false,
                'booked_by' => null,
                'booked_at' => null
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Консультация отменена'
        ]);
    }
}