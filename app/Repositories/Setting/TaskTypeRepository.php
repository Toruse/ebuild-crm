<?php

namespace App\Repositories\Setting;

use App\Models\Project\TaskType;

class TaskTypeRepository
{
    public function getTypesPaginate($paginate = 25)
    {
        return TaskType::paginate($paginate);
    }

    public function createNewType($fields)
    {
        return TaskType::create([
            'name' => $fields['name'],
        ]);
    }

    public function updateType(TaskType $type, $fields)
    {
        $type->name = $fields['name'];
        return $type->save();
    }

    public function addNewTaskType($taskTypeValue) {
        $taskTypeValue = trim($taskTypeValue);
        $taskType = TaskType::where('id', $taskTypeValue)
            ->orWhere('name', $taskTypeValue)
            ->first();
        if ($taskType) {
            return $taskType->id;
        } 

        $taskType = TaskType::create([
            'name' => $taskTypeValue,
        ]);

        return $taskType->id;
    }

    public static function isTaskType($taskTypeValue) {
        return TaskType::where('id', $taskTypeValue)
            ->orWhere('name', $taskTypeValue)
            ->first();
    }
}