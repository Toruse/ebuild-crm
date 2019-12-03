<?php

namespace App\Repositories\Setting;

use App\Models\User\Source;

class SourceRepository
{
    public function getSourcesPaginate($paginate = 25)
    {
        return Source::paginate($paginate);
    }

    public function createNewSource($fields)
    {
        return Source::create([
            'name' => $fields['name'],
        ]);
    }

    public function updateSource(Source $source, $fields)
    {
        $source->name = $fields['name'];
        return $source->save();
    }
}