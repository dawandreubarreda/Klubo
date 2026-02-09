<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Http\Request;
use Carbon\Carbon;

//Controlador para manejar la creación de temporadas en el panel de administración. 
//Permite a los administradores crear nuevas temporadas con un nombre, fecha de inicio y fecha de fin.
//Asegurándose de que el usuario confirme la acción escribiendo "confirmar" antes de proceder.

class SeasonController extends Controller
{
    public function create()
    {
        return view('admin.seasons.create');
    }

    public function store(Request $request)
    {
        // Validar que el usuario escribió "confirmar"
        if ($request->input('confirmation') !== 'confirmar') {
            return back()->withErrors(['confirmation' => 'Debes escribir "confirmar" para crear una temporada.']);
        }

        $request->validate([
            'name' => 'required|string|max:10|unique:seasons',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Season::create($request->only(['name', 'start_date', 'end_date']));

        return redirect()->route('admin.seasons.index')
            ->with('success', 'Temporada creada correctamente.');
    }

    // Método para mostrar la lista de temporadas.
    public function index()
    {
        $seasons = Season::all();
        
        // Encontrar la temporada actual
        $currentSeason = Season::whereDate('start_date', '<=', Carbon::today())
            ->whereDate('end_date', '>=', Carbon::today())
            ->first();

        return view('admin.seasons.index', compact('seasons', 'currentSeason'));
    }
    
}