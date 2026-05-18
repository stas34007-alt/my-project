<?php

namespace App\Http\Controllers;

use App\Models\AvailableSlot;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $doctors = Doctor::with(['user', 'specialization'])->get();

        $query = Consultation::with(['patient.user', 'doctor.user']);
        
        // Фильтр по статусу
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Фильтр по типу консультации
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Фильтр по дате от
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        // Фильтр по дате до
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $consultations = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $panding_consultation = Consultation::where('status', 'pending_payment')->get();
        $slots = AvailableSlot::all();
        
        return view('admin', compact('doctors', 'consultations', 'panding_consultation', 'slots'));
    }

    /**
     * Создание слота
     */
    public function createSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'slot_start' => 'required|date|after:now',
            'slot_end' => 'required|date|after:slot_start',
        ]);

        AvailableSlot::create($request->all());

        return redirect()->route('admin')->with('success', 'Слот создан');
    }

    /**
     * Удаление слота
     */
    public function destroy($id)
    {
        $slot = AvailableSlot::findOrFail($id);
        
        if (!$slot->is_booked) {
            $slot->delete();
            return back()->with('success', 'Слот удалён');
        }
        
        return back()->with('error', 'Нельзя удалить забронированный слот');
    }

    public function createDoctor(Request $request)
    {
        // Валидация
        $request->validate([
            'user_identifier' => 'required|string',
            'specialty' => 'required|string',
            'license_number' => 'required|string|unique:doctors,license_number',
            'years_of_experience' => 'nullable|integer',
            'online_consultation_price' => 'nullable|numeric',
        ]);

        // Найти пользователя
        $user = User::where('email', $request->user_identifier)
            ->orWhere('id', $request->user_identifier)
            ->firstOrFail();

        // Проверка
        if ($user->user_type === 'doctor') {
            return back()->with('error', 'Уже врач!');
        }

        // Создать врача
        Doctor::create([
            'user_id' => $user->id,
            'specialization_id' => $request->specialty, // или любое значение по умолчанию
            'slug' => $request->slug,
            'license_number' => $request->license_number,
            'years_of_experience' => $request->years_of_experience,
            'online_consultation_price' => $request->online_consultation_price ?? 0,
            'education' => $request->education,
            'work_experience' => $request->work_experience,
            'achievements' => $request->achievements,
            'bio' => $request->bio,
            'languages' => $request->languages,
            'avatar' => $request->avatar,
            'is_verified' => $request->has('is_verified'),
            'is_available_online' => $request->has('is_available_online') ? true : false,
            'rating' => 0,
            'total_reviews' => 0,
        ]);

        // Обновить тип пользователя
        $user->update(['user_type' => 'doctor']);

        return back()->with('success', 'Врач добавлен!');
    }
}