<?php

namespace App\Repositories\Setting;

use App\Models\Project\Type;

class TypeRepository
{
    public function getTypesPaginate($paginate = 25)
    {
        return Type::paginate($paginate);
    }

    public function createNewType($fields)
    {
        return Type::create([
            'name' => $fields['name'],
        ]);
    }

    public function updateType(Type $type, $fields)
    {
        $type->name = $fields['name'];
        return $type->save();
    }
}