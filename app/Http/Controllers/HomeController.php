<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Todo;
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
        ->where('start_date', '<=', now()->addDays(5))
        ->orderBy('start_date')
        ->limit(3) 
        ->get();

        $todoDay = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        $todaysTodos = Todo::where('user_id', Auth::id())
        ->where('date', '=', $todoDay)->get();
        
        return view('welcome')->with(['currentDay' => $currentDay, 'name' => auth()->user()->name, 'upcomingAppointments' => $upcomingAppointments, 'todaysTodos' => $todaysTodos]);
    }
}
