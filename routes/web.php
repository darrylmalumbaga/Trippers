<?php

use App\Http\Controllers\Auth\WorkOSController;
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
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
