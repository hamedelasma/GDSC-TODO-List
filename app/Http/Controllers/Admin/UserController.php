<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'data' => $users
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['required', 'unique:users,phone', 'min:10', 'numeric'],
            'password' => ['required', 'min:8', 'string'],
            'is_team_leader' => ['boolean'],
            'team_id' => ['required', 'exists:teams,id']
        ]);
        User::create($inputs);
        return response()->json([
            'data' => 'created'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $inputs = $request->validate([
            'name' => 'string',
            'phone' => ['unique:users,phone', 'min:10', 'numeric'],
            'password' => ['min:8', 'string'],
            'is_team_leader' => ['boolean'],
            'team_id' => ['exists:teams,id']
        ]);
        $user->update($inputs);
        return response()->json([
            'data' => 'updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'data' => 'deleted'
        ]);
    }
}
