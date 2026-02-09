<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SeasonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/roles', [RoleController::class, 'index'])->name('roles');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de administración
Route::middleware(['auth', 'verified'])->group(function () {
    // Usamos UserController directamente (gracias al "use" arriba)
    Route::get('/admin/roles', [UserController::class, 'index'])->name('admin.roles');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    //Rutas de gestión de temporadas
    Route::get('/admin/seasons', [SeasonController::class, 'index'])->name('admin.seasons.index');
    Route::get('/admin/seasons/create', [SeasonController::class, 'create'])->name('admin.seasons.create');
    Route::post('/admin/seasons', [SeasonController::class, 'store'])->name('admin.seasons.store');

    Route::get('/admin/teams', function () {
        return "Gestión de equipos (próximamente)";
    });

    Route::get('/admin/news', function () {
        return "Tablón de anuncios (próximamente)";
    });
});

require __DIR__.'/auth.php';