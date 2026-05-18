<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
  // Контроллер
    public function join($id)
    {
        $consultation = Consultation::with(['doctor.user', 'patient.user'])->findOrFail($id);
        
        // Проверка прав доступа
        if (Auth::id() != $consultation->doctor->user_id && Auth::id() != $consultation->patient->user_id) {
            abort(403);
        }
        
        return view('video-call', compact('consultation'));
    }

    public function endCall($id)
    {
        $consultation = Consultation::findOrFail($id);
        
        $consultation->update([
            'status' => 'completed',
            'ended_at' => now()
        ]);
        
        return response()->json(['success' => true]);
    }

    public function generateMeetingLink($id)
    {
        $consultation = Consultation::findOrFail($id);
        
        // Генерация уникальной комнаты
        $roomName = 'telemed_' . uniqid() . '_' . $consultation->id;
        $meetingLink = 'https://meet.jit.si/' . $roomName;
        
        $consultation->update([
            'meeting_link' => $meetingLink,
            'meeting_id' => $roomName
        ]);
        
        return response()->json([
            'success' => true,
            'meeting_link' => $meetingLink
        ]);
    }
}
