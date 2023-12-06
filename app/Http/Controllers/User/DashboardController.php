<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (!$this->checkIfIsTeamLeader()) {
            return response()->json([
                'data' => 'Only team leader can view the dashboard'
            ], 401);
        }

        $teams = Team::count();
        $tasks = Task::where('team_id', '=', auth()->user()->team_id)->count();
        $tasks2 = auth()->user()->team->tasks()->count();
        $tasksNotAssigned = auth()->user()->team->tasks()->where('user_id', '=', null)->count();
        $completedTasks = auth()->user()->team->tasks()->where('status', '=', 'Completed')->count();
        $thisWeekTask = auth()->user()->team->tasks()->where('created_at', '>', Carbon::now()->subWeek())->count();
        $yourTasks = auth()->user()->tasks()->count();
        return response()->json([
            'data' => [
                'teams' => $teams,
                'tasks' => $tasks,
                'tasks2' => $tasks2,
                'completedTasks' => $completedTasks,
                'thisWeekTask' => $thisWeekTask,
                'tasksNotAssigned' => $tasksNotAssigned,
                'yourTasks' => $yourTasks
            ]
        ]);
    }
}
