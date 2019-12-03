<?php

namespace App\Services;

use App\Models\Project\Type;
use App\Repositories\Setting\TypeRepository;

class ProjectTypeService
{
    protected $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function getTypesPaginate($paginate = 25)
    {
        return $this->typeRepository->getTypesPaginate($paginate);
    }

    public function createNewType($fields) {
        return $this->typeRepository->createNewType($fields);
    }

    public function updateType(Type $type, $fields) {        
        $this->typeRepository->updateType($type, $fields);
        
        return true;
    }
}