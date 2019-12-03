<?php

namespace App\Http\Controllers\Project;

use App\Models\Project\Task;
use App\Services\TaskService;
use App\Models\Project\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskChangeRequest;
use App\Http\Requests\Task\TaskEventDropRequest;
use App\Http\Requests\Task\TaskEventResizeRequest;
use App\Repositories\Setting\TaskTypeRepository;

class TaskController extends Controller
{
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function change(TaskChangeRequest $request, Task $task)
    {
        if ($task->project && $task->project->publish) {
            return response()->json([
                'status' => 'error',
            ]);    
        }

        $type = TaskTypeRepository::isTaskType($request->input('type'));

        $task = $this->taskService->changeTask($task, $request->all());
        return response()->json([
            'status' => 'ok',
            'htmlChangeTask' => view('project.task.index.item', [
                'task' => $task
            ])->render(),
            'htmlInfoProject' => view('project.project.info', [
                'project' => Project::find($task->project_id)
            ])->render(),
            'event' => $this->taskService->getDataEventToCalendar($task),
            'option' => $this->taskService->getNewTaskTypeToOption($task, $type),
        ]);
    }

    public function edit(Task $task) {
        return response()->json([
            'status' => 'ok',
            'task' => $this->taskService->getFormDataTask($task)
        ]);
    }

    public function destroy(Task $task)
    {
        if ($task->project && $task->project->publish) {
            return response()->json([
                'status' => 'error',
            ]);    
        }

        return response()->json([
            'status' => $task->delete()?'ok':'error',
            'htmlInfoProject' => view('project.project.info', [
                'project' => Project::find($task->project_id)
            ])->render(),
            'event' => $this->taskService->getDataEventToCalendar($task),
        ]);
    }

    public function eventDrop(TaskEventDropRequest $request, Task $task)
    {
        if ($task->project && $task->project->publish) {
            return response()->json([
                'status' => 'error',
            ]);    
        }

        $task = $this->taskService->eventDropTask($task, $request->all());
        return response()->json([
            'status' => 'ok',
            'htmlChangeTask' => view('project.task.index.item', [
                'task' => $task
            ])->render(),
            'htmlInfoProject' => view('project.project.info', [
                'project' => Project::find($task->project_id)
            ])->render(),
        ]);
    }

    public function eventResize(TaskEventResizeRequest $request, Task $task)
    {
        if ($task->project && $task->project->publish) {
            return response()->json([
                'status' => 'error',
            ]);    
        }

        $task = $this->taskService->eventResizeTask($task, $request->all());
        return response()->json([
            'status' => 'ok',
            'htmlChangeTask' => view('project.task.index.item', [
                'task' => $task
            ])->render(),
            'htmlInfoProject' => view('project.project.info', [
                'project' => Project::find($task->project_id)
            ])->render(),
        ]);
    }

}
