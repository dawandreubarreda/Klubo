<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    //CRUD para equipos.
    public function index()
    {
        $teams = Team::with(['season', 'category'])->get();
        return view('admin.teams.index', compact('teams'));
    }
}