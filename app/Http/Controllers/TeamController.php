<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{

    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'unique:teams,code']
        ]);
        Team::create($input);
        return response()->json([
            'data' => 'created'
        ]);
    }

    public function index()
    {
        $teams = Team::all();
        return response()->json([
            'data' => $teams
        ]);
    }

    public function update(Request $request, $team_id)
    {
        $team = Team::findOrFail($team_id);
        $inputs = $request->validate([
            'name' => ['string', 'max:255'],
            'code' => ['string', Rule::unique('teams', 'code')->ignore($team)]
        ]);
        $team->update($inputs);
        return response()->json([
            'data' => 'updated'
        ]);

    }

    public function delete($team_id)
    {
        $team = Team::findOrFail($team_id);
        $team->delete();
        return response()->json([
            'data' => 'deleted'
        ]);
    }

    public function show($team_id)
    {
        $team = Team::findOrFail($team_id);
        return response()->json([
            'data' => $team
        ]);
    }
}
