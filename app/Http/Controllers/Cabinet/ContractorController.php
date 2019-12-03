<?php

namespace App\Http\Controllers\Cabinet;

use Carbon\Carbon;
use App\Services\UserService;
use App\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContractorController extends Controller
{
    private $userService;
    private $taskService;

    public function __construct(UserService $userService, TaskService $taskService)
    {
        $this->userService = $userService;
        $this->taskService = $taskService;
    }

    public function calendarUpdateEvents()
    {
        return response()->json([
            'status' => 'ok',
            'events' => $this->taskService->getUserCurrentTasks()->map(function ($item, $key) {
                return [
                    'id' => $item->id,
                    'title' => $item->name,
                    'start' => $item->start_date,
                    'end' => $item->end_date_calendar,
                    'textColor' => 'white',
                    'color' => $item->color,
                ];
            })->all(),
        ]);
    } 
    
    public function tasksCompletedToday() {
        return response()->json([
            'status' => 'ok',
            'html' => view('cabinet.contractor.tasks-completed-today', [
                'tasks' => $this->taskService->getUserTasksToday(),
            ])->render(),
        ]);  
    }
}