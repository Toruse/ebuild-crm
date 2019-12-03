<?php

namespace App\Http\Controllers;

use App\Models\User\Role;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Services\UserService;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    private $userService;
    private $projectService;
    private $taskService;

    public function __construct(UserService $userService, ProjectService $projectService, TaskService $taskService)
    {
        $this->userService = $userService;
        $this->projectService = $projectService;
        $this->taskService = $taskService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        switch ($this->userService->getTypeCabinet()) {
            case Role::ROLE_CUSTOMER:
                return view('index.cabinet.client', [
                    'projects' => $this->projectService->getUserCurrentProjects(Auth::user()->id),
                ]);
            break;
            case Role::ROLE_CONTRACTOR:
                return view('index.cabinet.contractor', [
                    'tasks' => $this->taskService->getUserCurrentTasks(),
                ]);
            break;
        }
        return view('index.index');
    }
}
