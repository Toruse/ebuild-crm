<?php

namespace App\Services;

use App\Models\User\Source;
use App\Repositories\Setting\SourceRepository;

class SourceService
{
    protected $sourceRepository;

    public function __construct(SourceRepository $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
    }

    public function getSourcesPaginate($paginate = 25)
    {
        return $this->sourceRepository->getSourcesPaginate($paginate);
    }

    public function createNewSource($fields) {
        return $this->sourceRepository->createNewSource($fields);
    }

    public function updateSource(Source $source, $fields) {        
        $this->sourceRepository->updateSource($source, $fields);
        
        return true;
    }
}