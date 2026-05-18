<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\MedicalFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AutorisationController extends Controller
{
    public function index(){
        return view('auto');
    }

     public function Onas(){
        return view('Onas');
    }

    public function registration(){
        return view('register');
    }

    public function registr(Request $request){
        $request -> validate([
            'full_name' => 'required|max:100|regex:/^[А-Яа-яЁё]+\s[А-Яа-яЁё]+\s[А-Яа-яЁё]+$/u',
            'email' => 'required|unique:users',
            'telephone' => 'required|min:11',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'email' => $request->email,
            'full_name' => $request->full_name,
            'phone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Регистрация прошла успешно!');
    }

    public function authenticate(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(Auth::attempt($validated)) {
            $request->session()->regenerate();
    
            if(Auth::user()->user_type === 'admin') {
                return redirect()->route('admin');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ])->onlyInput('email');
    }




    public function private()
    {
        $user = Auth::user();
        
        // Базовые данные для всех пользователей
        $data = [
            'user' => $user,
            'userType' => $user->user_type
        ];
        
        // Логика для пациентов
        if ($user->user_type == 'patient') {
            $patient = Patient::where('user_id', $user->id)->first();
            
            if ($patient) {
                $data['patient'] = $patient;
                $data['consultationsCount'] = Consultation::where('patient_id', $patient->id)->count();
                
                $data['appointmentsUpcoming'] = Consultation::where('patient_id', $patient->id)
                    ->whereHas('slot', function($query) {
                        $query->where('slot_start', '>=', now());
                    })
                    ->count();
                    
                $data['filesCount'] = MedicalFile::where('patient_id', $patient->id)->count();
                
                // Последние консультации
                $data['recentConsultations'] = Consultation::where('patient_id', $patient->id)
                    ->with(['doctor', 'slot'])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
                    
                // Ближайшие приемы
                $data['upcomingAppointments'] = Consultation::where('patient_id', $patient->id)
                    ->whereHas('slot', function($query) {
                        $query->where('slot_start', '>=', now());
                    })
                    ->with(['doctor', 'slot'])
                    ->orderBy('created_at', 'asc')
                    ->limit(3)
                    ->get();
            }
        }
        
        // Логика для врачей
        if ($user->user_type == 'doctor') {
            $doctor = Doctor::where('user_id', $user->id)->first();
            
            if ($doctor) {
                $data['doctor'] = $doctor;
                
                // Количество пациентов
                $data['patientsCount'] = Consultation::where('doctor_id', $doctor->id)
                    ->distinct('patient_id')
                    ->count('patient_id');
                
                // Количество приемов сегодня
                $data['appointmentsToday'] = Consultation::where('doctor_id', $doctor->id)
                    ->whereHas('slot', function($query) {
                        $query->whereDate('slot_start', Carbon::today());
                    })
                    ->count();
                
                // Опыт работы (если есть поле years_of_experience)
                $data['experienceYears'] = $doctor->years_of_experience ?? 0;
                
                // Сегодняшние приемы
                $data['todayAppointments'] = Consultation::where('doctor_id', $doctor->id)
                    ->whereHas('slot', function($query) {
                        $query->whereDate('slot_start', Carbon::today())
                              ->orderBy('slot_start', 'asc');
                    })
                    ->with(['patient', 'slot'])
                    ->limit(10)
                    ->get();
                
                // Предстоящие приемы
                $data['upcomingAppointments'] = Consultation::where('doctor_id', $doctor->id)
                    ->whereHas('slot', function($query) {
                        $query->where('slot_start', '>', now());
                    })
                    ->with(['patient', 'slot'])
                    ->orderBy('created_at', 'asc')
                    ->limit(5)
                    ->get();
                
                // Общее количество консультаций
                $data['totalConsultations'] = Consultation::where('doctor_id', $doctor->id)->count();
                
                // Специализация врача
                $data['specialization'] = $doctor->specialization ?? 'Не указана';
            }
        }
        
        return view('private_room', $data);
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:M,F,O',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        
        // Обновление основных данных
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = $request->gender;
        $user->address = $request->address;
        
        // Обработка аватара
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            $avatarName = time() . '_' . $user->id . '.' . $avatarFile->getClientOriginalExtension();
            $avatarFile->move(public_path('images/avatars'), $avatarName);
            
            // Удаление старого аватара
            if ($user->avatar && file_exists(public_path('images/avatars/' . $user->avatar))) {
                unlink(public_path('images/avatars/' . $user->avatar));
            }
            
            $user->avatar = $avatarName;
        }
        
        $user->save();
        
        return redirect()->route('private')->with('success', 'Профиль успешно обновлен!');
    }
}

