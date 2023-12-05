<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth('api')->user()->tasks()->with('team')->get();
        return response()->json([
            'data' => $tasks
        ]);
    }

    public function show(string $id)
    {
        $task = auth('api')->user()->tasks()->findOrFail($id)->load('team');
        return response()->json([
            'data' => $task
        ]);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->is_team_leader) {
            return response()->json([
                'error' => 'You are not allowed to create tasks'
            ], 403);
        }
        $inputs = $request->validate([
            'name' => ['required', 'string'],
            'status' => ['in:Not-Started, In-Progress,Completed,Canceled'],
            'user_id' => ['exists:users,id'],
        ]);
        $task = auth('api')->user()->team->tasks()->create($inputs);
        return response()->json([
            'data' => $task
        ]);
    }

    public function update(Request $request, string $id)
    {
        $task = auth('api')->user()->tasks()->findOrFail($id);
        $inputs = $request->validate([
            'status' => 'in:Not-Started,In-Progress,Completed,Canceled',
        ]);
        $task->update($inputs);
        return response()->json([
            'data' => 'updated'
        ]);
    }

    public function assignedTask(Request $request, string $id)
    {
        if (!auth()->user()->is_team_leader) {
            return response()->json([
                'error' => 'You are not allowed to create tasks'
            ], 403);
        }
        $task = auth('api')->user()->team->tasks()->findOrFail($id);
        $inputs = $request->validate([
            'user_id' => ['exists:users,id'],
        ]);
        $task->update($inputs);
        return response()->json([
            'data' => 'updated'
        ]);
    }

    public function teamTasks()
    {
        $tasks = auth('api')->user()->team->tasks()->with('user')->get();
        return response()->json([
            'data' => $tasks
        ]);
    }



}
