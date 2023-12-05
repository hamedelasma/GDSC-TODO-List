<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $numberOfTasks = $request->user()->tasks()->count();
        $completedTasks = $request->user()->tasks()->where('status', 'Completed')->count();
        $canceledTasks = $request->user()->tasks()->where('status', 'Canceled')->count();
        $inProgressTasks = $request->user()->tasks()->where('status', 'In-Progress')->count();
        $notStartedTasks = $request->user()->tasks()->where('status', 'Not-Started')->count();
        $numberOfTasksThisMonth = $request->user()->tasks()->whereMonth('created_at', now()->month)->count();
        $numberOfTasksThisYear = $request->user()->tasks()->whereYear('created_at', now()->year)->count();
        return response()->json([
            'data' => [
                'numberOfTasks' => $numberOfTasks,
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
