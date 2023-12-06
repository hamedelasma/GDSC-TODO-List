<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $users = User::count();
        $teams = Team::count();
        $tasks = Task::count();
        $completedTasks = Task::where('status' ,'=','Completed')->count();
        $thisWeekTask = Task::where('created_at' ,'>',Carbon::now()->subWeek())->count();
        $userForThisMonth= User::where('created_at', '>', Carbon::now()->subMonth())->count();

        return response()->json([
            'data' => [
                'users' => $users,
                'teams'=> $teams,
                'tasks'=> $tasks,
                'completedTasks' => $completedTasks,
                'thisWeekTask'=> $thisWeekTask,
                'userForThisMonth' => $userForThisMonth
            ]
        ]);

    }
}
