<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomLogoutController;
use App\Http\Controllers\MapaController;

Route::post('/logout', [CustomLogoutController::class, 'destroy'])
    ->name('logout');

// Página de inicio pública
Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas (solo usuarios logueados)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Redirigir /dashboard al mapa
    Route::get('/dashboard', function () {
        return redirect()->route('mapa');
    })->name('dashboard');

    // Mapa interactivo principal
    Route::get('/mapa', [MapaController::class, 'index'])->name('mapa');

    // Búsqueda AJAX de ubicaciones
    Route::get('/mapa/buscar', [MapaController::class, 'buscar'])->name('mapa.buscar');

});
