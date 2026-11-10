<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\Cliente\ClienteController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\EmbarcacionController;
use Illuminate\Support\Facades\Route;

// Ruta principal para cuando se entre en la URL raiz
Route::get('/', [PrincipalController::class, 'index'])->name('principal');

//Ruta para el dashboard con correo verificado
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas agrupadas solo para usuarios logueados
Route::middleware('auth')->group(function () {

    // Rutas de perfil de Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ruta del panel de cliente
    Route::get('/mi-panel', [ClienteController::class, 'index'])->name('cliente.dashboard');

    // RUTAS PROTEGIDAS PARA EL BACKOFFICE (Solo Admin y Empleados)
    Route::middleware('verificar.rol')->group(function () {
        
        // ruta principal del backoffice (Carga la vista unificada SPA)
        Route::get('/backoffice', [AdminController::class, 'index'])->name('admin.backoffice');

        // Rutas de gestión para el Backoffice (Aceptar / Denegar reservas)
        Route::patch('/backoffice/reserva/{id}/aceptar', [AdminController::class, 'aceptarReserva'])->name('admin.reserva.aceptar');
        Route::patch('/backoffice/reserva/{id}/denegar', [AdminController::class, 'denegarReserva'])->name('admin.reserva.denegar');

        // Ruta para actualizar el estado de un amarre (desde el panel del Backoffice)
        Route::patch('/backoffice/amarres/{id}', [AdminController::class, 'actualizarEstadoAmarre'])->name('admin.amarres.update');

        // Rutas para la administración de usuarios
        Route::patch('/backoffice/usuarios/{id}/rol', [AdminController::class, 'actualizarRol'])->name('admin.usuarios.rol');
        Route::patch('/backoffice/usuarios/{id}/estado', [AdminController::class, 'cambiarEstadoUsuario'])->name('admin.usuarios.estado');
    });

    // Rutas para reservar (solo usuarios logueados)
    Route::get('/reservar/{id_amarre}', [ReservaController::class, 'create'])->name('reserva.create');
    Route::post('/reservar', [ReservaController::class, 'store'])->name('reserva.store');

    //ruta para cancelar una reserva
    Route::patch('/mi-panel/reserva/{id}/cancelar', [ReservaController::class, 'cancelarReserva'])->name('cliente.reserva.cancelar');

    //Rutas para las embarcaciones
    //ruta para dar de alta una nueva embarcación
    Route::post('/mi-panel/embarcaciones', [EmbarcacionController::class, 'store'])->name('cliente.barcos.store');
    
    //ruta para editar una embarcación existente
    Route::put('/mi-panel/embarcaciones/{id}', [EmbarcacionController::class, 'update'])->name('cliente.barcos.update');
    
    //ruta para eliminar una embarcación existente
    Route::delete('/mi-panel/embarcaciones/{id}', [EmbarcacionController::class, 'destroy'])->name('cliente.barcos.destroy');

    //ruta para actualizar los datos personales del usuario
    Route::put('/mi-panel/datos', [ClienteController::class, 'updateDatos'])->name('cliente.datos.update');
});

//Cuando el usuario haga click en un pin del mapa js hará una petición fetch a Laravel.
//Los datos de la petición irá en la url sustituyendo codigo por el CP de cada municipio
//Ruta de la api para el tiempo
Route::get('/api/tiempo/{codigo}', [PrincipalController::class,  'obtenerTiempoApi']);

// Ruta de la api para obtener los detalles de un muelle y sus amarres en formato JSON
Route::get('/api/muelle/{id}', [PrincipalController::class, 'obtenerDetallesMuelle'])->name('api.muelle.detalles');

// Rutas para las páginas legales
Route::get('/aviso-legal', [App\Http\Controllers\LegalController::class, 'aviso'])->name('legal.aviso');
Route::get('/politica-privacidad', [App\Http\Controllers\LegalController::class, 'privacidad'])->name('legal.privacidad');
Route::get('/politica-cookies', [App\Http\Controllers\LegalController::class, 'cookies'])->name('legal.cookies');
Route::get('/terminos-y-condiciones', [App\Http\Controllers\LegalController::class, 'terminos'])->name('legal.terminos');
Route::get('/politica-reembolsos', [App\Http\Controllers\LegalController::class, 'reembolsos'])->name('legal.reembolsos');

// Rutas para el formulario de contacto
Route::get('/contacto', [App\Http\Controllers\ContactoController::class, 'index'])->name('contacto.index');
Route::post('/contacto', [App\Http\Controllers\ContactoController::class, 'store'])->name('contacto.store');

require __DIR__ . '/auth.php';