<?php

namespace App\Repositories\Project;

use Carbon\Carbon;
use App\Models\Project\Task;
use App\Models\Project\Project;
use App\Models\Project\TaskUser;

class TaskRepository
{
    public function createTask($fields)
    {
        return Task::create([
            'project_id' => $fields['project'],
            'color' => $fields['color'],
            'start_date' => (new Carbon($fields['start_date']))->format('Y-m-d'),
            'end_date' => (new Carbon($fields['end_date']))->format('Y-m-d'),
            'note' => $fields['note'],
            'task_type_id' => $fields['type']
        ]);
    }

    public function updateTask(Task $task, $fields)
    {
        $task->project_id = $fields['project'];
        $task->color = $fields['color'];
        $task->user_start_date = $fields['start_date'];
        $task->user_end_date = $fields['end_date'];
        $task->note = $fields['note'];
        $task->task_type_id = $fields['type'];
        return $task->save();
    }

    public function getTasksListIds(array $ids) {
        return Task::whereIn('id', $ids)->get();
    }

    public function clearNotAssignedTask() {
        Task::whereNull('project_id')
            ->where('created_at', '<', Carbon::today())
            ->delete();
    }

    public function updateAssignedTaskToProject(Project $project, $ids) {
        Task::whereIn('id', $ids)
            ->update(['project_id' => $project->id]);
    }

    public function getFormDataTask(Task $task) {
        $arrayTask = $task->toArray();

        $arrayTask['type'] = $arrayTask['task_type_id'];
        unset($arrayTask['task_type_id']);

        $arrayTask['start_date'] = $task->user_start_date;
        $arrayTask['end_date'] = $task->user_end_date;

        $arrayTask['bind_users[]'] = $task->bindUsers->pluck('id');

        return $arrayTask;
    }

    public function updateStartEndDateTask(Task $task, $fields)
    {
        $task->start_date = $fields['start_date'];
        $task->end_date = $fields['end_date'];
        return $task->save();
    }

    public function getUserCurrentTasks($userId)
    {
        return Task::with('bindUsers')
            ->select('tasks.*')
            ->from(Task::getTableName().' AS tasks')
            ->leftJoin(Project::getTableName().' AS projects', function($join) {
                $join->on('tasks.project_id', '=', 'projects.id');
            })
            ->leftJoin(TaskUser::getTableName().' AS task_users', function($join) {
                $join->on('tasks.id', '=', 'task_users.task_id');
            })
            ->where(function($query) {
                $query->whereDate('projects.end_date', '>=', Carbon::today());
                $query->orWhereNull('projects.end_date');
            })
            ->where(function($query) {
                $query->whereDate('tasks.end_date', '>=', Carbon::today());
                $query->orWhereNull('tasks.end_date');
            })
            ->where('projects.publish', 1)
            ->where('task_users.user_id', $userId)
            ->get();
    }

    public function getUserTasksToday($userId) {
        return Task::with('bindUsers')
            ->select('tasks.*')
            ->from(Task::getTableName().' AS tasks')
            ->leftJoin(Project::getTableName().' AS projects', function($join) {
                $join->on('tasks.project_id', '=', 'projects.id');
            })
            ->leftJoin(TaskUser::getTableName().' AS task_users', function($join) {
                $join->on('tasks.id', '=', 'task_users.task_id');
            })
            ->where(function($query) {
                $query->whereDate('projects.end_date', '>=', Carbon::today());
                $query->orWhereNull('projects.end_date');
            })
            ->where(function($query) {
                $query->whereDate('tasks.start_date', '<=', Carbon::today());
                $query->whereDate('tasks.end_date', '>=', Carbon::today());
            })
            ->where('projects.publish', 1)
            ->where('task_users.user_id', $userId)
            ->get();
    }
}