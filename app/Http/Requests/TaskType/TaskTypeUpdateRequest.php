<?php

namespace App\Http\Requests\TaskType;

use Illuminate\Foundation\Http\FormRequest;

class TaskTypeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:50',
        ];
    }
}