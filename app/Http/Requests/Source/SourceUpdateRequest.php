<?php

namespace App\Http\Requests\Source;

use Illuminate\Foundation\Http\FormRequest;

class SourceUpdateRequest extends FormRequest
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