<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Services\UserService;
use App\Models\Project\Project;
use App\Models\Project\Schedule;
use App\Services\ProjectService;
use App\Services\TaskTypeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectCreateRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\Http\Requests\Project\ProjectPublishRequest;
use App\Http\Requests\Project\ProjectEventDropRequest;
use App\Http\Requests\Project\ProjectEventResizeRequest;

class ProjectController extends Controller
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

    public function index()
    {
        return view('project.project.index', [
            'projects' => $this->projectService->getCurrentDateProjects()
        ]);
    }

    public function create(Request $request) {

        $selectDate = $request->input('selectdate');

        return view('project.project.create', [
            'listCustomerUsers' => $this->userService->mapListCustomers(),
            'listBindUsers' =>  $this->userService->mapListBindUsers(),
            'listProjectType' => $this->projectService->pluckListTypes(),
            'listProjectManager' => $this->userService->listProjectManager(),
            'tasks' => $this->taskService->getTasksListIds(old('task_ids')),
            'project_id' => null,
            'schedules' => $this->projectService->getSchedules(),
            'select_date' => $selectDate,
            'listTaskTypes' => TaskTypeService::pluckListTaskTypes(),
        ]);
    }

    public function store(ProjectCreateRequest $request)
    {
        $this->projectService->createNewProject($request->all());
        return redirect()->route('projects');
    }

    public function edit(Project $project) {
        return view('project.project.edit', [
            'project' => $project,
            'project_id' => $project->id,
            'listCustomerUsers' => $this->userService->mapListCustomers(),
            'listBindUsers' =>  $this->userService->mapListBindUsers(),
            'listProjectType' => $this->projectService->pluckListTypes(),
            'listProjectManager' => $this->userService->listProjectManager(false),
            'tasks' => $project->tasks,
            'schedules' => $this->projectService->getSchedules(),
            'listTaskTypes' => TaskTypeService::pluckListTaskTypes(),
        ]);
    }

    public function editJson(Project $project) {
        return response()->json([
            'status' => 'ok',
            'project' => $this->projectService->getFormDataProject($project)
        ]);
    }

    public function update(ProjectUpdateRequest $request, Project $project) {
        if ($project->publish) {
            return response()->json([
                'status' => 'error',
            ]);    
        }

        $this->projectService->updateProject($project, $request->all());

        $project = Project::findOrFail($project->id);

        return response()->json([
            'status' => 'ok',
            'html' => view('project.project.info', [
                'project' => $project
            ])->render(),
        ]);
    }

    public function destroy($id)
    {
        Project::destroy($id);
        return redirect()->route('projects');
    }

    public function eventDrop(ProjectEventDropRequest $request, Project $project)
    {
        if ($project->publish) {
            return response()->json([
                'status' => 'error',
            ]);    
        }

        $project = $this->projectService->eventDropProject($project, $request->all());
        return response()->json([
            'status' => 'ok',
            'htmlUpdateProject' => view('project.project.index.item', [
                'project' => $project
            ])->render(),
        ]);
    }

    public function eventResize(ProjectEventResizeRequest $request, Project $project)
    {
        if ($project->publish) {
            return response()->json([
                'status' => 'error',
            ]);    
        }

        $project = $this->projectService->eventResizeProject($project, $request->all());
        return response()->json([
            'status' => 'ok',
            'htmlUpdateProject' => view('project.project.index.item', [
                'project' => $project
            ])->render()
        ]);
    }

    public function getList()
    {
        return response()->json([
            'status' => 'ok',
            'html' => view('project.schedule.get-list', [
                'schedules' => $this->projectService->getSchedules(),
            ])->render()
        ]);
    }

    public function publish(ProjectPublishRequest $request, Project $project) {
        if ($project->publish) {
            return response()->json([
                'status' => 'error',
            ]);    
        }
        
        $project = $this->projectService->setPublishProject($project, $request->all());

        return response()->json([
            'status' => 'ok',
        ]);
    }
}
