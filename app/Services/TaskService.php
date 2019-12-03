<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Project\Task;
use App\Models\Project\TaskType;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Project\TaskRepository;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Project\TaskUserRepository;
use App\Repositories\Setting\TaskTypeRepository;

class TaskService
{
	protected $taskRepository;
    protected $taskTypeRepository;
    protected $taskUserRepository;

    public function __construct(TaskRepository $taskRepository, TaskTypeRepository $taskTypeRepository, TaskUserRepository $taskUserRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->taskTypeRepository = $taskTypeRepository;
        $this->taskUserRepository = $taskUserRepository;
    }
    
    public function changeTask(Task $task, $fields) {
        if (isset($fields['type'])) {
            $fields['type'] = $this->taskTypeRepository->addNewTaskType($fields['type']);
            $task->task_type_id = $fields['type'];
        }

        if ($task->id) {
            $this->taskRepository->updateTask($task, $fields);
        } else {
            $task = $this->taskRepository->createTask($fields);
        }

        if ($task->project_id) {
            ProjectRepository::updateEndDate($task->project_id);
        }

        if (isset($fields['bind_users'])) {
            $this->taskUserRepository->attachUsersForTask($task->id, $fields['bind_users']);
        }

        return $task;
    }

    public function getTasksListIds(?array $ids) {
        if (!$ids) {
            $ids = [];
        }
        return $this->taskRepository->getTasksListIds($ids);
    }

    public function getFormDataTask(Task $task) {
        return $this->taskRepository->getFormDataTask($task);
    }

    public function getDataEventToCalendar(Task $task) {
        return self::convertDataTaskToCalendar($task);
    }

    public static function getDataEventsToCalendar($tasks) {
        $result = [];

        foreach ($tasks as $task) {
            $result[] = self::convertDataTaskToCalendar($task);
        }

        return $result;
    }

    private static function convertDataTaskToCalendar(Task $task) {
        return [
            'id' => $task->id,
            'title' => $task->name,
            'start' => $task->start_date,
            'end' => $task->end_date_calendar,
            'url' => route('tasks.edit', ['task' => $task]),
            'textColor' => 'white',
            'color' => $task->color,
            'data' => [
                'urlEventDrop' => route('tasks.event-drop', ['task' => $task]),
                'urlEventResize' => route('tasks.event-resize', ['task' => $task]),
            ]
        ];
    }

    public function eventDropTask(Task $task, $fields) {
        
        $fields['end_date'] = (new Carbon($fields['end_date']))->subDays(1)->format('Y-m-d');

        $this->taskRepository->updateStartEndDateTask($task, $fields);

        if ($task->project_id) {
            ProjectRepository::updateEndDate($task->project_id);
        }

        return $task;
    }

    public function eventResizeTask(Task $task, $fields) {
        
        $fields['end_date'] = (new Carbon($fields['end_date']))->subDays(1)->format('Y-m-d');

        $this->taskRepository->updateStartEndDateTask($task, $fields);

        if ($task->project_id) {
            ProjectRepository::updateEndDate($task->project_id);
        }

        return $task;
    }

    public function getNewTaskTypeToOption(Task $task, ?TaskType $type) {
        return $type?false:['id' => $task->type->id, 'text' => $task->type->name];
    }

    public function getUserCurrentTasks() {
        return $this->taskRepository->getUserCurrentTasks(Auth::user()->id);
    }

    public function getUserTasksToday() {
        return $this->taskRepository->getUserTasksToday(Auth::user()->id);
    }
}