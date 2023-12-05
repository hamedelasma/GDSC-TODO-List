<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $numberOfUsers = User::count();
        $numberOfTeams = Team::count();
        $totalOfTasks = Task::count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $canceledTasks = Task::where('status', 'Canceled')->count();
        $inProgressTasks = Task::where('status', 'In-Progress')->count();
        $notStartedTasks = Task::where('status', 'Not-Started')->count();
        $numberOfTasksThisMonth = Task::whereMonth('created_at', now()->month)->count();
        $numberOfTasksThisYear = Task::whereYear('created_at', now()->year)->count();
        return response()->json([
            'data' => [
                'numberOfUsers' => $numberOfUsers,
                'numberOfTeams' => $numberOfTeams,
                'totalOfTasks' => $totalOfTasks,
                'completedTasks' => $completedTasks,
                'canceledTasks' => $canceledTasks,
                'inProgressTasks' => $inProgressTasks,
                'notStartedTasks' => $notStartedTasks,
                'numberOfTasksThisMonth' => $numberOfTasksThisMonth,
                'numberOfTasksThisYear' => $numberOfTasksThisYear,
            ]
        ]);
    }
}
