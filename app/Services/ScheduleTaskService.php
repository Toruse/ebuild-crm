<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Project\TaskType;
use App\Models\Project\ScheduleTask;
use App\Repositories\Setting\TaskTypeRepository;
use App\Repositories\Project\ScheduleTaskRepository;
use App\Repositories\Project\ScheduleTaskUserRepository;

class ScheduleTaskService
{
    protected $scheduleTaskRepository;
    protected $taskTypeRepository;
    protected $scheduleTaskUserRepository;

    public function __construct(ScheduleTaskRepository $scheduleTaskRepository, TaskTypeRepository $taskTypeRepository, ScheduleTaskUserRepository $scheduleTaskUserRepository)
    {
        $this->scheduleTaskRepository = $scheduleTaskRepository;
        $this->taskTypeRepository = $taskTypeRepository;
        $this->scheduleTaskUserRepository = $scheduleTaskUserRepository;
    }
    
    public function changeTask(ScheduleTask $task, $fields) {
        if (isset($fields['type'])) {
            $fields['type'] = $this->taskTypeRepository->addNewTaskType($fields['type']);
            $task->task_type_id = $fields['type'];
        }

        if ($task->id) {
            $this->scheduleTaskRepository->updateTask($task, $fields);
        } else {
            $task = $this->scheduleTaskRepository->createTask($fields);
        }

        if (isset($fields['bind_users'])) {
            $this->scheduleTaskUserRepository->attachUsersForTask($task->id, $fields['bind_users']);
        }

        return $task;
    }

    public function getTasksListIds(?array $ids) {
        if (!$ids) {
            $ids = [];
        }
        return $this->scheduleTaskRepository->getTasksListIds($ids);
    }

    public function getFormDataTask(ScheduleTask $task) {
        return $this->scheduleTaskRepository->getFormDataTask($task);
    }

    public function getNewTaskTypeToOption(ScheduleTask $task, ?TaskType $type) {
        return $type?false:['id' => $task->type->id, 'text' => $task->type->name];
    }

    public function getDataEventToCalendar(ScheduleTask $task) {
        return self::convertDataTaskToCalendar($task);
    }

    public static function getDataEventsToCalendar($tasks) {
        $result = [];

        foreach ($tasks as $task) {
            $result[] = self::convertDataTaskToCalendar($task);
        }

        return $result;
    }

    private static function convertDataTaskToCalendar(ScheduleTask $task) {
        return [
            'id' => $task->id,
            'title' => $task->name,
            'start' => $task->start_date,
            'end' => $task->end_date_calendar,
            'url' => route('schedule-tasks.edit', ['scheduleTask' => $task]),
            'textColor' => 'white',
            'color' => $task->color,
            'data' => [
                'urlEventDrop' => route('schedule-tasks.event-drop', ['scheduleTask' => $task]),
                'urlEventResize' => route('schedule-tasks.event-resize', ['scheduleTask' => $task]),
            ]
        ];
    }

    public function eventDropTask(ScheduleTask $task, $fields) {
        
        $fields['end_date'] = (new Carbon($fields['end_date']))->subDays(1)->format('Y-m-d');

        $this->scheduleTaskRepository->updateStartEndDateTask($task, $fields);

        return $task;
    }

    public function eventResizeTask(ScheduleTask $task, $fields) {
        
        $fields['end_date'] = (new Carbon($fields['end_date']))->subDays(1)->format('Y-m-d');

        $this->scheduleTaskRepository->updateStartEndDateTask($task, $fields);

        return $task;
    }

    public function getScheduleTasks(ScheduleTask $task) {
        if ($task->schedule && $task->schedule->tasks) {
            return $task->schedule->tasks;
        }
        return null;
    }
}