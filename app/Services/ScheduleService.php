<?php

namespace App\Services;

use App\Models\Project\Task;
use App\Models\Project\TaskType;
use App\Models\Project\Schedule;
use App\Models\Project\ScheduleTask;
use App\Repositories\Project\ScheduleRepository;
use App\Repositories\Project\ProjectRepository;

class ScheduleService
{
	protected $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function getSchedulesPaginate($paginate = 25)
    {
        return $this->scheduleRepository->getSchedulesPaginate($paginate);
    }

    public function createNewSchedule($fields) {
        return $this->scheduleRepository->createNewSchedule($fields);
    }
    
    public function updateSchedule(Schedule $schedule, $fields) {        
        $this->scheduleRepository->updateSchedule($schedule, $fields);
        
        return true;
    }

    public function getListAddTask($fields) {
        $tasks = collect();

        $startDate = $fields['start_date'];

        $scheduleTasks = $this->scheduleRepository->getCopyScheduleTask($fields['schedule']);

        if ($scheduleTasks->isEmpty()) return $tasks;

        $minDate = $scheduleTasks->first()['start_date'];

        foreach ($scheduleTasks as $scheduleTask) {
            $scheduleTask->start_date = date('Y-m-d', strtotime($startDate)+strtotime($scheduleTask->start_date)-strtotime($minDate));
            $scheduleTask->end_date = date('Y-m-d', strtotime($startDate)+strtotime($scheduleTask->end_date)-strtotime($minDate));
            $task = $this->scheduleRepository->copyScheduleTask($scheduleTask, $fields['project']);
            $tasks->push($task);
        }

        if ($fields['project']) {
            ProjectRepository::updateEndDate($fields['project']);
        }

        return $tasks;
    }

    public function getRequestModal() {
        $modal = request()->input('modal');

        if ($modal && class_exists('\Debugbar')) {
            \Debugbar::disable();
        }

        return $modal?'-modal':'';
    }

    public function getFirstDateTask(Schedule $schedule)
    {
        return $this->scheduleRepository->getFirstDateTask($schedule);
    }
}