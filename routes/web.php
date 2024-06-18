<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

//Home Route
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

//Calendar Routes
Route::middleware('auth')->group(function () {
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::post('calendar', [CalendarController::class, 'store'])->name('calendar.store');
    Route::patch('calendar/update/{id}', [CalendarController::class, 'update'])->name('calendar.update');
    Route::delete('calendar/destroy/{id}', [CalendarController::class, 'destroy'])->name('calendar.destroy');
});

//Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Todo Routes
Route::middleware('auth')->group(function () {
    Route::get('todo', [TodoController::class, 'index'])->name('todo');
});

require __DIR__.'/auth.php';
