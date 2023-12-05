<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all()->load('team', 'user');
        return response()->json([
            'data' => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
                'name' => ['required', 'string'],
                'status' => ['in:Not-Started, In-Progress,Completed,Canceled'],
                'user_id' => ['exists:users,id'],
                'team_id' => ['required', 'exists:teams,id']
            ]
        );
        Task::create($inputs);
        return response()->json([
            'data' => 'created'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id)->load('team', 'user');
        return response()->json([
            'data' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);
        $inputs = $request->validate([
            'name' => 'string',
            'status' => '',
            'team_id' => ['exists:teams,id'],
            'user_id' => ['exists:users,id']
        ]);
        $task->update($inputs);
        return response()->json([
            'data' => 'updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json([
            'data' => 'deleted'
        ]);
    }
}
