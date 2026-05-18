<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AutorisationController;
use App\Http\Controllers\AvailableSlotController;
use App\Http\Controllers\Doctor\DoctorDiagnosisController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\MedicalFileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Авторизация и регистрация
Route::get('/autorisation',[AutorisationController::class, 'index'])->name('autorisation');
Route::get('/registration',[AutorisationController::class, 'registration'])->name('registration');
Route::post('/registration',[AutorisationController::class, 'registr'])->name('registr');
Route::post('/autorisation',[AutorisationController::class, 'authenticate'])->name('authenticate');


//Доктора 
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctor');
Route::get('/showdoctor/{id}',[DoctorController::class, 'show_doctor'])->name('show_doctor');
Route::post('/showdoctor/consultations/{id}',[DoctorController::class, 'consultations'])->name('consultations');

//Личный кабинет

Route::get('/private_room',[AutorisationController::class, 'private'])->name('private');
Route::put('/private_room', [AutorisationController::class, 'update'])->name('private.update');

//Админ панель
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::post('/admin/createSlots', [AdminController::class, 'createSlots'])->name('createSlots');
Route::post('/admin/createDoctor', [AdminController::class, 'createDoctor'])->name('createDoctor');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('destroy');

//О нас
Route::get('/Onas', [AutorisationController::class, 'Onas'])->name('Onas');

//Консультация
Route::get('/my-consultations', [MedicalFileController::class, 'index'])->name('my.consultations');
Route::get('/my-consultations/{id}', [MedicalFileController::class, 'show'])->name('my.consultations.show');
Route::put('/my-consultations/{id}/cancel', [MedicalFileController::class, 'cancel'])->name('my.consultations.cancel');

//Анализы
Route::get('/diagnosis', [DoctorDiagnosisController::class, 'index'])->name('doctor.diagnosis.index');
Route::get('/diagnosis/create/{id}', [DoctorDiagnosisController::class, 'create'])->name('doctor.diagnosis.form');
Route::post('/diagnosis/store/{id}', [DoctorDiagnosisController::class, 'store'])->name('doctor.diagnosis.store');
Route::get('/diagnosis/show/{id}', [DoctorDiagnosisController::class, 'show'])->name('doctor.diagnosis.show');
Route::get('/diagnosis/edit/{id}', [DoctorDiagnosisController::class, 'edit'])->name('doctor.diagnosis.edit');
Route::put('/diagnosis/update/{id}', [DoctorDiagnosisController::class, 'update'])->name('doctor.diagnosis.update');

// Консультация
Route::get('/consultation/{id}/join', [ConsultationController::class, 'join'])->name('consultation.join');
Route::post('/consultation/{id}/end', [ConsultationController::class, 'endCall'])->name('consultation.end');
Route::post('/consultations/{id}/generate-link', [ConsultationController::class, 'generateMeetingLink'])->name('consultations.generate-link');
