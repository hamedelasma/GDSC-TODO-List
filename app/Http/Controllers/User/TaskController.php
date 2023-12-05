<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = auth()->user()->tasks()->get();
        return response()->json([
            'data' => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->is_team_leader) {
            return response()->json([
                'data' => 'Only team leader can create task'
            ], 401);
        }
        $inputs = $request->validate([
            'name' => ['required', 'string'],
            'status' => ['in:Not-Started, In-Progress,Completed,Canceled'],
            'user_id' => ['exists:users,id']
        ]);
        auth()->user()->team->tasks()->create($inputs);
        return response()->json([
            'data' => 'created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'status' => ['required', 'in:Not-Started,In-Progress,Completed,Canceled'],
        ]);
        auth()
            ->user()
            ->tasks()
            ->findOrFail($id)
            ->update($inputs);
        return response()->json([
            'data' => 'updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
