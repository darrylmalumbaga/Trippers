<?php

use App\Http\Controllers\Auth\WorkOSController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\TripCollaboratorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::get('/', fn () => Inertia::render('Welcome'));

Route::get('login/workos', [WorkOSController::class, 'login'])->name('login.workos');
Route::get('authenticate', [WorkOSController::class, 'callback']);
Route::post('authenticate', [WorkOSController::class, 'handleCallback']);

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::get('dashboard', function () {
        $trips = auth()->user()->trips()->latest()->take(3)->get()->map(function ($trip) {
            $trip->days_left = $trip->start_date ? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($trip->start_date), false) : null;
            return $trip;
        });

        return Inertia::render('Dashboard', [
            'trips' => $trips,
        ]);
    })->name('dashboard');

    Route::resource('trips', TripController::class);
    Route::post('trips/{trip}/duplicate', [TripController::class, 'duplicate'])->name('trips.duplicate');
    Route::resource('trips.collaborators', TripCollaboratorController::class)->shallow()->only(['store', 'destroy']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
