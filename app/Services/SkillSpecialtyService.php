<?php

namespace App\Services;

use App\Models\User\SkillSpecialty;
use App\Repositories\Setting\SkillSpecialtyRepository;

class SkillSpecialtyService
{
    protected $skillSpecialtyRepository;

    public function __construct(SkillSpecialtyRepository $skillSpecialtyRepository)
    {
        $this->skillSpecialtyRepository = $skillSpecialtyRepository;
    }

    public function getSkillSpecialtysPaginate($paginate = 25)
    {
        return $this->skillSpecialtyRepository->getSkillSpecialtysPaginate($paginate);
    }

    public function pluckListSkillSpecialty($key = 'id', $value = 'name')
    {
        return SkillSpecialty::orderBy('name')
            ->pluck($value, $key)
            ->all();
    }

    public function createNewSkillSpecialty($fields) {
        return $this->skillSpecialtyRepository->createNewSkillSpecialty($fields);
    }

    public function updateSkillSpecialty(SkillSpecialty $skillSpecialty, $fields) {        
        $this->skillSpecialtyRepository->updateSkillSpecialty($skillSpecialty, $fields);
        
        return true;
    }
}