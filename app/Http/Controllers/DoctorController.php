<?php

namespace App\Http\Controllers;

use App\Models\AvailableSlot;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::with(['user', 'specialization'])->get();
        return view('doctors', compact('doctors'));
    }

    public function show_doctor(Request $request, $id)
{
    $doctor = Doctor::with('user', 'specialization')->findOrFail($id);
    
    // Сегодняшние слоты (только сегодня)1
    $todaySlots = AvailableSlot::where('doctor_id', $id)
        ->whereDate('slot_start', now()->toDateString())
        ->where('slot_start', '>=', now()) // только будущие слоты сегодня
        ->orderBy('slot_start')
        ->get();
    
    // Завтрашние слоты (только завтра)2
    $tomorrowSlots = AvailableSlot::where('doctor_id', $id)
        ->whereDate('slot_start', now()->addDay()->toDateString())
        ->orderBy('slot_start')
        ->get();
    
    // Послезавтрашние слоты (только послезавтра)3
    $afterTomorrowSlots = AvailableSlot::where('doctor_id', $id)
        ->whereDate('slot_start', now()->addDays(2)->toDateString())
        ->orderBy('slot_start')
        ->get();

    // ПослеПослезавтрашние слоты (только послеПослезавтра)4
    $ForTomorrowSlots = AvailableSlot::where('doctor_id', $id)
        ->whereDate('slot_start', now()->addDays(3)->toDateString())
        ->orderBy('slot_start')
        ->get();

    // Послезавтрашние слоты (только послезавтра)5
    $FiveTomorrowSlots = AvailableSlot::where('doctor_id', $id)
        ->whereDate('slot_start', now()->addDays(4)->toDateString())
        ->orderBy('slot_start')
        ->get();    

    // Послезавтрашние слоты (только послезавтра)6
    $SixTomorrowSlots = AvailableSlot::where('doctor_id', $id)
        ->whereDate('slot_start', now()->addDays(5)->toDateString())
        ->orderBy('slot_start')
        ->get();   
        
    // Послезавтрашние слоты (только послезавтра)7
    $SevenTomorrowSlots = AvailableSlot::where('doctor_id', $id)
        ->whereDate('slot_start', now()->addDays(6)->toDateString())
        ->orderBy('slot_start')
        ->get();       
    
    return view('showDoctor', compact('doctor', 'todaySlots', 'tomorrowSlots', 'afterTomorrowSlots','ForTomorrowSlots','FiveTomorrowSlots','SixTomorrowSlots', 'SevenTomorrowSlots'));
}

    public function consultations(Request $request, $slotId){
        
        $slot = AvailableSlot::findOrFail($slotId);

        $user = auth()->user();
        $patient = $user->patient;

        Consultation::create([
            'patient_id' => $patient->id,
            'doctor_id' => $slot->doctor_id,
            'slot_id' => $slot->id,
            'type' => 'video',
            'status' => 'scheduled',
        ]);

        $slot->update(['is_booked' => true]);
    
        return redirect()->route('show_doctor', $slot->doctor_id)
            ->with('success', '✅ Вы успешно записаны к врачу!');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
