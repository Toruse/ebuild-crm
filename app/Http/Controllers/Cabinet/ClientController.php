<?php

namespace App\Http\Controllers\Cabinet;

use Carbon\Carbon;
use App\Services\UserService;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    private $userService;
    private $projectService;

    public function __construct(UserService $userService, ProjectService $projectService)
    {
        $this->userService = $userService;
        $this->projectService = $projectService;
    }

    public function calendarUpdateEvents()
    {
        return response()->json([
            'status' => 'ok',
            'events' => $this->projectService->getUserCurrentProjects(Auth::user()->id)->map(function ($item, $key) {
                return [
                    'id' => $item->id,
                    'title' => $item->customerFullName,
                    'start' => (new Carbon($item->start_date))->format('Y-m-d h:i:s'),
                    'end' => (new Carbon($item->end_date))->format('Y-m-d h:i:s'),
                    'textColor' => 'white',
                    'color' => $item->color,
                ];
            })->all(),
        ]);
    }    
}