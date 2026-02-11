<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use App\Models\Season;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TeamController extends Controller
{
    //CRUD para equipos.
    public function index()
    {
        $teams = Team::with(['season', 'category'])->get();
        return view('admin.teams.index', compact('teams'));
    }
    // Mostrar formulario para crear un nuevo equipo
    public function create()
    {
        $seasons = Season::all();
        $categories = Category::all();
        return view('admin.teams.create', compact('seasons', 'categories'));
    }
    
    // Guardar un nuevo equipo en la base de datos.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'season_id' => 'required|exists:seasons,id',
            'category_id' => 'required|exists:categories,id',
            'gender' => 'required|in:masculino,femenino,mixto'
        ]);

        Team::create($request->only(['name', 'season_id', 'category_id', 'gender']));

        return redirect()->route('admin.teams.index')
            ->with('success', 'Equipo creado correctamente.');
    }

    // Mostrar equipos por temporada.
    public function showBySeason(Season $season)
    {
        $teams = $season->teams()->with('category')->get();
        return view('admin.teams.by-season', compact('season', 'teams'));
    }

    // Mostrar formulario para editar un equipo existente.
    public function edit(Team $team, Request $request)
    {
        $seasons = Season::all();
        $categories = Category::all();
        $redirectBack = $request->query('redirect_back');
        
        return view('admin.teams.edit', compact('team', 'seasons', 'categories', 'redirectBack'));
    }

    // Actualizar un equipo existente en la base de datos.
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'season_id' => 'required|exists:seasons,id',
            'category_id' => 'required|exists:categories,id',
            'gender' => 'required|in:masculino,femenino,mixto'
        ]);

        $team->update($request->only(['name', 'season_id', 'category_id', 'gender']));

        // Redirigir a la URL de origen si existe
        if ($request->has('redirect_back')) {
            return redirect($request->input('redirect_back'))
                ->with('success', 'Equipo actualizado correctamente.');
        }

        return redirect()->route('admin.teams.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    // Mostrar formulario para gestionar miembros de un equipo.
    public function manageMembers(Team $team)
    {
        // Usuarios disponibles (que no están ya en el equipo)
        $availableUsers = User::whereDoesntHave('teams', function($query) use ($team) {
            $query->where('team_id', $team->id);
        })->get();

        // Miembros actuales del equipo
        $currentMembers = $team->users()->withPivot('role_in_team')->get();

        return view('admin.teams.members', compact('team', 'availableUsers', 'currentMembers'));
    }

    // Agregar un miembro al equipo.
    public function addMember(Request $request, Team $team)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_in_team' => 'required|in:player,coach'
        ]);

        $user = User::findOrFail($request->user_id);

        if ($team->users()->where('user_id', $user->id)->exists()) {
            return back()->withErrors(['user_id' => 'Este usuario ya está en el equipo.']);
        }
        
        if ($request->role_in_team === 'player') {
            if (!$this->validatePlayerEligibility($team, $user)) {
                return back()->withErrors(['user_id' => 'Este usuario no cumple los requisitos de edad o género para este equipo.']);
            }
        }

        $team->users()->attach($user->id, ['role_in_team' => $request->role_in_team]);
        return back()->with('success', 'Miembro añadido correctamente.');
    }

    // Eliminar un miembro del equipo.
    public function removeMember(Request $request, Team $team)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $team->users()->detach($request->user_id);

        return back()->with('success', 'Miembro eliminado correctamente.');
    }

    // Validar que un jugador cumple con los requisitos de edad y género para un equipo específico.
    private function validatePlayerEligibility(Team $team, User $user)
    {
        if ($team->gender !== 'mixto') {
            if ($user->gender !== $team->gender) {
                return false;
            }
        }

        // Definir las fechas correctamente
        $userBirthDate = \Carbon\Carbon::parse($user->birth_date);
        $referenceDate = \Carbon\Carbon::parse($team->season->start_date);
        
        // Calcular años cumplidos exactamente
        $userAge = $userBirthDate->diff($referenceDate)->y;

        $allowedCategories = $this->getAllowedCategories($team->category);
        
        // Depuración: mostrar qué categorías se consideran permitidas
        $debugInfo = [
            'user_age' => $userAge,
            'team_category' => $team->category->name,
            'allowed_categories' => $allowedCategories->pluck('name', 'id')->toArray(),
            'allowed_age_ranges' => $allowedCategories->map(function($cat) {
                return $cat->name . ' (' . $cat->min_age . '-' . $cat->max_age . ')';
            })->toArray()
        ];

        foreach ($allowedCategories as $category) {
            if ($userAge >= $category->min_age && $userAge <= $category->max_age) {
                return true;
            }
        }
        
        return false;
    }

    // Obtener categorías permitidas para un equipo (categoría del equipo + hasta 2 categorías inferiores).
    private function getAllowedCategories(Category $teamCategory)
    {
        // Obtener todas las categorías ordenadas por min_age
        $allCategories = Category::orderBy('min_age')->get();
        
        // Encontrar el índice de la categoría del equipo
        $teamCategoryIndex = null;
        foreach ($allCategories as $index => $category) {
            if ($category->id === $teamCategory->id) {
                $teamCategoryIndex = $index;
                break;
            }
        }
        
        if ($teamCategoryIndex === null) {
            return collect([$teamCategory]);
        }
        
        // Permitir la categoría del equipo + hasta 2 categorías inferiores
        $allowedCategories = [];
        for ($i = max(0, $teamCategoryIndex - 2); $i <= $teamCategoryIndex; $i++) {
            $allowedCategories[] = $allCategories[$i];
        }
        
        return collect($allowedCategories);
    }
}