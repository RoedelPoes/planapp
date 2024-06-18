<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $currentDay = Carbon::now()->format('F jS');
        $upcomingAppointments = Booking::where('user_id', Auth::id())
        ->where('start_date', '>=', now())
        ->orderBy('start_date')
        ->limit(3) 
        ->get();
        
        return view('welcome')->with(['currentDay' => $currentDay, 'name' => auth()->user()->name, 'upcomingAppointments' => $upcomingAppointments]);
    }
}