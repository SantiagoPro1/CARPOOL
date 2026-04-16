<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');



Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

use App\Http\Controllers\ViajeController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalificacionController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/buscar', [SearchController::class, 'index'])->name('search.index');
    
    Route::post('/viajes/{viaje}/solicitar', [SolicitudController::class, 'store'])->name('solicitudes.store');
    Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
    Route::put('/solicitudes/{solicitud}', [SolicitudController::class, 'update'])->name('solicitudes.update');
    
    Route::get('/viajes/{viaje}/chat', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/viajes/{viaje}/chat', [ChatController::class, 'store'])->name('chat.store');
    
    // Invitados
    Route::post('/viajes/{viaje}/invitar', [ViajeController::class, 'invitar'])->name('viajes.invitar');
    Route::delete('/solicitudes/{solicitud}/cancelar', [SolicitudController::class, 'cancelar'])->name('solicitudes.cancelar');

    Route::resource('viajes', ViajeController::class);
    Route::resource('vehiculos', VehiculoController::class);
    
    Route::get('/perfil/{usuario?}', [ProfileController::class, 'show'])->name('perfil.show');
    Route::get('/viajes/{viaje}/calificar/{evaluado}', [CalificacionController::class, 'create'])->name('calificar.create');
    Route::post('/viajes/{viaje}/calificar/{evaluado}', [CalificacionController::class, 'store'])->name('calificar.store');
});
