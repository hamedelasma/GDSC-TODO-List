<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{


    public function login()
    {
        $credentials = request(['phone', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function profile(Request $request)
    {
        $user = [
            'name' => auth()->user()->name,
            'phone' => auth()->user()->phone,
            'team' => auth()->user()->team->name
        ];
        return response()->json([
            'data' => $user
        ]);
    }

    public function register(Request $request)
    {
        $inputs = $request->validate([
            'phone' => ['required', 'unique:users,phone', 'numeric'],
            'password' => ['required', 'min:8'],
            'name' => ['required', 'string'],
            'team_code' => ['required', 'exists:teams,code']
        ]);
        $team = Team::where('code', '=', $inputs['team_code'])->first();
        $team->users()->create($inputs);
        return response()->json([
            'data' => 'created'
        ]);
    }
}
