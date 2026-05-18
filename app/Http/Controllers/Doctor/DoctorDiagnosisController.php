<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorDiagnosisController extends Controller
{
    /**
     * Список пациентов для записи диагноза
     */
    public function index()
    {
        $doctor = Auth::user()->doctor;
        
        $consultations = Consultation::where('doctor_id', $doctor->id)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->with('patient.user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('doctor.diagnosis.index', compact('consultations'));
    }
    
    /**
     * Форма записи диагноза
     */
    public function create($id)
    {
        $consultation = Consultation::where('id', $id)
            ->where('doctor_id', Auth::user()->doctor->id)
            ->with('patient.user')
            ->firstOrFail();
        
        return view('doctor.diagnosis.form', compact('consultation'));
    }
    
    /**
     * Сохранить диагноз (для новых записей)
     */
    public function store(Request $request, $id)
    {

        $request->validate([
            'diagnosis' => 'required|string|min:3',
            'doctor_notes' => 'nullable|string',
            'status' => 'required|in:completed,in_progress',
            'type' => 'nullable|in:video,chat,phone',
            'meeting_link' => 'nullable|url|max:255',
            'meeting_id' => 'nullable|string|max:255',
            'final_price' => 'nullable|numeric|min:0',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date',
            'rating' => 'nullable|integer|min:1|max:5',
            'review' => 'nullable|string',
            'cancellation_reason' => 'nullable|string|max:255',
        ]);
        
        $consultation = Consultation::where('id', $id)
            ->where('doctor_id', Auth::user()->doctor->id)
            ->firstOrFail();
        
        // Подготовка данных для обновления
        $data = [
            'diagnosis' => $request->diagnosis,
            'doctor_notes' => $request->doctor_notes,
            'status' => $request->status,
        ];
        
        // Устанавливаем дату окончания, если статус "завершена"
        if ($request->status == 'completed') {
            $data['ended_at'] = now();
        }
        
        // Добавляем остальные поля
        if ($request->filled('type')) {
            $data['type'] = $request->type;
        }
        
        if ($request->filled('meeting_link')) {
            $data['meeting_link'] = $request->meeting_link;
        }
        
        if ($request->filled('meeting_id')) {
            $data['meeting_id'] = $request->meeting_id;
        }
        
        if ($request->filled('final_price')) {
            $data['final_price'] = $request->final_price;
        }
        
        if ($request->filled('started_at')) {
            $data['started_at'] = $request->started_at;
        }
        
        if ($request->filled('ended_at') && $request->status != 'completed') {
            $data['ended_at'] = $request->ended_at;
        }
        
        if ($request->filled('rating')) {
            $data['rating'] = $request->rating;
        }
        
        if ($request->filled('review')) {
            $data['review'] = $request->review;
        }
        
        if ($request->filled('cancellation_reason')) {
            $data['cancellation_reason'] = $request->cancellation_reason;
            $data['cancelled_at'] = now();
        }
        
        $consultation->update($data);
        
        $message = $request->status == 'completed' 
            ? 'Диагноз сохранён и консультация завершена' 
            : 'Диагноз сохранён';
        
        return redirect()->route('doctor.diagnosis.index')->with('success', $message);
    }
    
    /**
     * Просмотр диагноза
     */
    public function show($id)
    {
        $consultation = Consultation::where('id', $id)
            ->where('doctor_id', Auth::user()->doctor->id)
            ->with('patient.user')
            ->firstOrFail();
        
        return view('doctor.diagnosis.show', compact('consultation'));
    }
    
    /**
     * Редактировать диагноз
     */
    public function edit($id)
    {
        $consultation = Consultation::where('id', $id)
            ->where('doctor_id', Auth::user()->doctor->id)
            ->with('patient.user')
            ->firstOrFail();
        
        return view('doctor.diagnosis.form', compact('consultation'));
    }
    
    /**
     * Обновить диагноз (для существующих записей)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'diagnosis' => 'required|string|min:3',
            'doctor_notes' => 'nullable|string',
            'type' => 'nullable|in:video,chat,phone',
            'meeting_link' => 'nullable|url|max:255',
            'meeting_id' => 'nullable|string|max:255',
            'final_price' => 'nullable|numeric|min:0',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date',
            'rating' => 'nullable|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);
        
        $consultation = Consultation::where('id', $id)
            ->where('doctor_id', Auth::user()->doctor->id)
            ->firstOrFail();
        
        $data = [
            'diagnosis' => $request->diagnosis,
            'doctor_notes' => $request->doctor_notes
        ];
        
        if ($request->filled('type')) {
            $data['type'] = $request->type;
        }
        
        if ($request->filled('meeting_link')) {
            $data['meeting_link'] = $request->meeting_link;
        }
        
        if ($request->filled('meeting_id')) {
            $data['meeting_id'] = $request->meeting_id;
        }
        
        if ($request->filled('final_price')) {
            $data['final_price'] = $request->final_price;
        }
        
        if ($request->filled('started_at')) {
            $data['started_at'] = $request->started_at;
        }
        
        if ($request->filled('ended_at')) {
            $data['ended_at'] = $request->ended_at;
        }
        
        if ($request->filled('rating')) {
            $data['rating'] = $request->rating;
        }
        
        if ($request->filled('review')) {
            $data['review'] = $request->review;
        }
        
        $consultation->update($data);
        
        return redirect()->route('doctor.diagnosis.show', $id)->with('success', 'Диагноз обновлён');
    }
}