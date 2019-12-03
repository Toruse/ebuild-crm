<?php

namespace App\Repositories\Setting;

use App\Models\User\SkillSpecialty;
use App\Models\User\UserSkillSpecialty;

class SkillSpecialtyRepository
{
    public function getSkillSpecialtysPaginate($paginate = 25)
    {
        return SkillSpecialty::paginate($paginate);
    }

    public function createNewSkillSpecialty($fields)
    {
        return SkillSpecialty::create([
            'name' => $fields['name'],
        ]);
    }

    public function updateSkillSpecialty(SkillSpecialty $skillSpecialty, $fields)
    {
        $skillSpecialty->name = $fields['name'];
        return $skillSpecialty->save();
    }

    public function addNewSkillSpecialty($field) {
        if (!is_array($field)) {
            return $field;
        }

        $skillSpecialtyIds = SkillSpecialty::whereIn('id', $field)->pluck('id', 'id')->all();

        $skillSpecialtyIds = array_diff($field, $skillSpecialtyIds);

        foreach ($skillSpecialtyIds as $value) {
            $skillSpecialty = SkillSpecialty::create([
                'name' => $value,
            ]);
            $key = array_search($value, $field);
            $field[$key] = $skillSpecialty->id;
        }

        return SkillSpecialty::whereIn('id', $field)->pluck('id', 'id')->all();
    }

    public function attachSkillSpecialtyForUser($userId, $attachs)
    {
        foreach ($attachs as $attach) {
            UserSkillSpecialty::create([
                'user_id' => $userId,
                'skill_specialty_id' => $attach,
            ]);
        }

        return true;
    }

    public function clearAttachUserSkillSpecialty($userId) {
        UserSkillSpecialty::where(['user_id' => $userId])->delete();
    }
}