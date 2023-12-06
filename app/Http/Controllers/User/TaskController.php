<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
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
        if (!$this->checkIfIsTeamLeader()) {
            return response()->json([
                'data' => 'Only team leader can create task to user'
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

    public function teamTasks()
    {

        $tasks = auth()
            ->user()
            ->team
            ->tasks()
            ->get();
        return response()->json([
            'data' => $tasks
        ]);
    }

    public function assignTask(Request $request, $taskId)
    {
        if (!$this->checkIfIsTeamLeader()) {
            return response()->json([
                'data' => 'Only team leader can assign task to user'
            ], 401);
        }
        $input = $request->validate([
            'user_id' => ['required', 'exists:users,id']
        ]);
        $task = Task::findOrFail($taskId);
        $user = User::find($input['user_id']);
        if ($user->team_id != auth()->user()->team_id) {
            return response()->json([
                'data' => 'This user not part of your team'
            ], 401);
        }
        if (auth()->user()->team_id != $task->team_id) {
            return response()->json([
                'data' => 'This Task not part of your tasks'
            ], 401);
        }
        $task->update([
            'user_id' => $user->id
        ]);
        return response()->json([
            'data' => 'updated'
        ]);
    }

    private function checkIfIsTeamLeader()
    {
        return auth()->user()->is_team_leader;
    }
}
