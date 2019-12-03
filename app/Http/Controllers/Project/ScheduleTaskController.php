<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\ScheduleTask;
use App\Services\ScheduleTaskService;
use App\Http\Requests\ScheduleTask\ScheduleTaskChangeRequest;
use App\Repositories\Setting\TaskTypeRepository;
use App\Http\Requests\ScheduleTask\ScheduleTaskEventDropRequest;
use App\Http\Requests\ScheduleTask\ScheduleTaskEventResizeRequest;

class ScheduleTaskController extends Controller
{
    private $scheduleTaskService;

    public function __construct(ScheduleTaskService $scheduleTaskService)
    {
        $this->scheduleTaskService = $scheduleTaskService;
    }

    public function change(ScheduleTaskChangeRequest $request, ScheduleTask $scheduleTask)
    {
        $type = TaskTypeRepository::isTaskType($request->input('type'));

        $scheduleTask = $this->scheduleTaskService->changeTask($scheduleTask, $request->all());
        return response()->json([
            'status' => 'ok',
            'html' => view('project.schedule-task.index', [
                'tasks' => $this->scheduleTaskService->getScheduleTasks($scheduleTask),
            ])->render(),
            'option' => $this->scheduleTaskService->getNewTaskTypeToOption($scheduleTask, $type),
            'event' => $this->scheduleTaskService->getDataEventToCalendar($scheduleTask),
        ]);
    }

    public function edit(ScheduleTask $scheduleTask) {
        return response()->json([
            'status' => 'ok',
            'task' => $this->scheduleTaskService->getFormDataTask($scheduleTask)
        ]);
    }

    public function destroy(ScheduleTask $scheduleTask)
    {
        return response()->json([
            'status' => $scheduleTask->delete()?'ok':'error',
            'event' => $this->scheduleTaskService->getDataEventToCalendar($scheduleTask),
        ]);
    }

    public function eventDrop(ScheduleTaskEventDropRequest $request, ScheduleTask $scheduleTask)
    {
        $scheduleTask = $this->scheduleTaskService->eventDropTask($scheduleTask, $request->all());
        return response()->json([
            'status' => 'ok',
            'htmlChangeTask' => view('project.schedule-task.index.item', [
                'task' => $scheduleTask,
            ])->render(),
        ]);
    }

    public function eventResize(ScheduleTaskEventResizeRequest $request, ScheduleTask $scheduleTask)
    {
        $scheduleTask = $this->scheduleTaskService->eventResizeTask($scheduleTask, $request->all());
        return response()->json([
            'status' => 'ok',
            'htmlChangeTask' => view('project.schedule-task.index.item', [
                'task' => $scheduleTask,
            ])->render(),
        ]);
    }
}
