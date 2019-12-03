<?php

namespace App\Repositories\Project;

use Carbon\Carbon;
use App\Models\Project\Task;
use App\Models\Project\Schedule;
use App\Models\Project\TaskUser;
use App\Models\Project\ScheduleTask;

class ScheduleRepository
{
    public function getSchedulesPaginate($paginate = 25)
    {
        return Schedule::paginate($paginate);
    }

    public function createNewSchedule($fields)
    {
        return Schedule::create([
            'title' => $fields['title'],
            'description' => $fields['description'],
        ]);
    }

    public function updateSchedule(Schedule $schedule, $fields)
    {
        $schedule->title = $fields['title'];
        $schedule->description = $fields['description'];
        return $schedule->save();
    }

    public function copyScheduleTask(ScheduleTask $scheduleTask, $projectId = null) {
        $task = Task::create([
            'contractor_id' => $scheduleTask->contractor_id,
            'project_id' => $projectId,
            'name' => $scheduleTask->name,
            'color' => $scheduleTask->color,
            'start_date' => $scheduleTask->start_date,
            'end_date' => $scheduleTask->end_date,
            'note' => $scheduleTask->note,
            'task_type_id' => $scheduleTask->task_type_id,
        ]);

        foreach ($scheduleTask->bindUsers as $bindUser) {
            TaskUser::create([
                'task_id' => $task->id,
                'user_id' => $bindUser->id,
            ]);
        }

        return $task;
    }

    public function getCopyScheduleTask($schedule_id) {
        return ScheduleTask::where(['schedule_id' => $schedule_id])
        ->orderBy('start_date')
        ->get();
    }

    public function getFirstDateTask(Schedule $schedule)
    {
        if ($schedule->firstTask) {
            return (new Carbon($schedule->firstTask->start_date))->format('Y-m-d');
        } else {
            return Carbon::today()->format('Y-m-d');
        }
    }
}