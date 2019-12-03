<?php

namespace App\Repositories\Setting;

use App\Models\User\MaterialService;
use App\Models\User\UserMaterialService;

class MaterialServiceRepository
{
    public function getMaterialServicesPaginate($paginate = 25)
    {
        return MaterialService::paginate($paginate);
    }

    public function createNewMaterialService($fields)
    {
        return MaterialService::create([
            'name' => $fields['name'],
        ]);
    }

    public function updateMaterialService(MaterialService $materialService, $fields)
    {
        $materialService->name = $fields['name'];
        return $materialService->save();
    }

    public function addNewMaterialService($field) {
        if (!is_array($field)) {
            return $field;
        }

        $materialServiceIds = MaterialService::whereIn('id', $field)->pluck('id', 'id')->all();

        $materialServiceIds = array_diff($field, $materialServiceIds);

        foreach ($materialServiceIds as $value) {
            $materialService = MaterialService::create([
                'name' => $value,
            ]);
            $key = array_search($value, $field);
            $field[$key] = $materialService->id;
        }

        return MaterialService::whereIn('id', $field)->pluck('id', 'id')->all();
    }

    public function attachMaterialServiceForUser($userId, $attachs)
    {
        foreach ($attachs as $attach) {
            UserMaterialService::create([
                'user_id' => $userId,
                'material_service_id' => $attach,
            ]);
        }

        return true;
    }

    public function clearAttachUserMaterialService($userId) {
        UserMaterialService::where(['user_id' => $userId])->delete();
    }
}