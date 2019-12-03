<?php

namespace App\Services;

use App\Models\Project\TaskType;
use App\Repositories\Setting\TaskTypeRepository;

class TaskTypeService
{
    protected $taskTypeRepository;

    public function __construct(TaskTypeRepository $taskTypeRepository)
    {
        $this->taskTypeRepository = $taskTypeRepository;
    }

    public function getTypesPaginate($paginate = 25)
    {
        return $this->taskTypeRepository->getTypesPaginate($paginate);
    }

    public function createNewType($fields) {
        return $this->taskTypeRepository->createNewType($fields);
    }

    public function updateType(TaskType $type, $fields) {        
        $this->taskTypeRepository->updateType($type, $fields);
        
        return true;
    }

    public static function isTaskType($valueType) {
        return TaskTypeRepository::isTaskType($valueType);
    }

    public static function pluckListTaskTypes($key = 'id', $value = 'name')
    {
        return ['' => '-- Choose Task --'] + TaskType::orderBy($value)->pluck($value, $key)
            ->all() + ['add_new' => 'Add New'];
    }
}