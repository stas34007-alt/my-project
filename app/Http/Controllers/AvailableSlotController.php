<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailableSlotController extends Controller
{
    public function index()
    {
        $slots = AvailableSlot::with('doctor.user')->latest()->paginate(20);
        return view('admin', compact('slots'));
    }


}