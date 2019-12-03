<?php

namespace App\Repositories\Project;

use Carbon\Carbon;
use App\Models\Project\ScheduleTask;

class ScheduleTaskRepository
{
    public function createTask($fields)
    {
        return ScheduleTask::create([
            'schedule_id' => $fields['schedule'],
            'color' => $fields['color'],
            'start_date' => (new Carbon($fields['start_date']))->format('Y-m-d'),
            'end_date' => (new Carbon($fields['end_date']))->format('Y-m-d'),
            'note' => $fields['note'],
            'task_type_id' => $fields['type'],
        ]);
    }

    public function updateTask(ScheduleTask $task, $fields)
    {
        $task->color = $fields['color'];
        $task->user_start_date = $fields['start_date'];
        $task->user_end_date = $fields['end_date'];
        $task->note = $fields['note'];
        $task->task_type_id = $fields['type'];
        return $task->save();
    }

    public function getTasksListIds(array $ids) {
        return ScheduleTask::whereIn('id', $ids)->get();
    }

    public function getFormDataTask(ScheduleTask $task) {
        $arrayTask = $task->toArray();

        $arrayTask['type'] = $arrayTask['task_type_id'];
        unset($arrayTask['task_type_id']);

        $arrayTask['start_date'] = $task->user_start_date;
        $arrayTask['end_date'] = $task->user_end_date;

        $arrayTask['bind_users[]'] = $task->bindUsers->pluck('id');

        return $arrayTask;
    }

    public function updateStartEndDateTask(ScheduleTask $task, $fields)
    {
        $task->start_date = $fields['start_date'];
        $task->end_date = $fields['end_date'];
        return $task->save();
    }
}