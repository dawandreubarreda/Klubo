<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Coach\CoachController;
use App\Http\Controllers\Coach\AttendanceController;
use App\Http\Controllers\Player\PlayerController;
use App\Http\Controllers\NewsController;
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

    // Área del entrenador
    Route::get('/coach/dashboard', [CoachController::class, 'dashboard'])->name('coach.dashboard');
    Route::get('/coach/teams/{team}', [CoachController::class, 'showTeam'])->name('coach.teams.show');
    Route::post('/coach/teams/{team}/players', [CoachController::class, 'addPlayer'])->name('coach.teams.add-player');
    // Gestión de asistencias
    Route::get('/coach/teams/{team}/attendances', [AttendanceController::class, 'index'])->name('coach.attendances.index');
    Route::post('/coach/teams/{team}/attendances', [AttendanceController::class, 'store'])->name('coach.attendances.store');
    Route::put('/coach/teams/{team}/attendances', [AttendanceController::class, 'update'])->name('coach.attendances.update');
    Route::delete('/coach/teams/{team}/attendances/{training}', [AttendanceController::class, 'destroy'])->name('coach.attendances.destroy');

    // Área del jugador
    Route::get('/player/dashboard', [PlayerController::class, 'dashboard'])->name('player.dashboard');
    Route::get('/player/teams/{team}/attendances', [PlayerController::class, 'showAttendances'])->name('player.attendances.show');
});

// Rutas de administración
    Route::middleware(['auth', 'verified'])->group(function () {
    // Usamos UserController directamente (gracias al "use" arriba)
    Route::get('/admin/roles', [UserController::class, 'index'])->name('admin.roles');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    
    // Rutas de gestión de temporadas
    Route::get('/admin/seasons', [SeasonController::class, 'index'])->name('admin.seasons.index');
    Route::get('/admin/seasons/create', [SeasonController::class, 'create'])->name('admin.seasons.create');
    Route::post('/admin/seasons', [SeasonController::class, 'store'])->name('admin.seasons.store');
    Route::get('/admin/seasons/{season}/teams', [TeamController::class, 'showBySeason'])->name('admin.seasons.teams');

    // Rutas de gestión de equipos
    Route::get('/admin/teams', [TeamController::class, 'index'])->name('admin.teams.index');
    Route::get('/admin/teams/create', [TeamController::class, 'create'])->name('admin.teams.create');
    Route::post('/admin/teams', [TeamController::class, 'store'])->name('admin.teams.store');
    Route::get('/admin/teams/{team}/edit', [TeamController::class, 'edit'])->name('admin.teams.edit');
    Route::put('/admin/teams/{team}', [TeamController::class, 'update'])->name('admin.teams.update');
    Route::get('/admin/teams/{team}/members', [TeamController::class, 'manageMembers'])->name('admin.teams.members');
    Route::post('/admin/teams/{team}/members', [TeamController::class, 'addMember'])->name('admin.teams.add-member');
    Route::delete('/admin/teams/{team}/members', [TeamController::class, 'removeMember'])->name('admin.teams.remove-member');

    // Tablón de anuncios (público)
Route::get('/news', [NewsController::class, 'index'])->name('news.index');

// Rutas protegidas (requieren autenticación)
    Route::middleware('auth')->group(function () {
        Route::post('/news', [NewsController::class, 'store'])->name('news.store');
        Route::post('/news/{newsPost}/comments', [NewsController::class, 'storeComment'])->name('news.comments.store');
        Route::post('/news/{newsPost}/like', [NewsController::class, 'toggleLike'])->name('news.like.toggle');
    });
});

require __DIR__.'/auth.php';
