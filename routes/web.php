<?php


use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\InterventionsController;
use App\Http\Controllers\ModelsController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UsersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('tickets', TicketsController::class);
    Route::resource('interventions', InterventionsController::class);
    Route::resource('devices', ModelsController::class);
    // Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/administration/{tab?}', [AdministrationController::class, 'index'])->name('administration');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::put('/users', [UsersController::class, 'edit'])->name('users.edit');
    Route::get('clients', [ClientsController::class, 'index'])->name('clients.index');
    Route::post('clients', [ClientsController::class, 'store'])->name('clients.store');
    Route::put('clients', [ClientsController::class, 'edit'])->name('clients.edit');
});
