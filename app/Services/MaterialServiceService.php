<?php

namespace App\Services;

use App\Models\User\MaterialService;
use App\Repositories\Setting\MaterialServiceRepository;

class MaterialServiceService
{
    protected $materialServiceRepository;

    public function __construct(MaterialServiceRepository $materialServiceRepository)
    {
        $this->materialServiceRepository = $materialServiceRepository;
    }

    public function getMaterialServicesPaginate($paginate = 25)
    {
        return $this->materialServiceRepository->getMaterialServicesPaginate($paginate);
    }

    public function pluckListMaterialService($key = 'id', $value = 'name')
    {
        return MaterialService::orderBy('name')
            ->pluck($value, $key)
            ->all();
    }

    public function createNewMaterialService($fields) {
        return $this->materialServiceRepository->createNewMaterialService($fields);
    }

    public function updateMaterialService(MaterialService $materialService, $fields) {        
        $this->materialServiceRepository->updateMaterialService($materialService, $fields);
        
        return true;
    }
}