<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => 'nullable|integer|exists:roles,id',
            'number' => 'nullable|integer',
            'priced' => 'nullable|integer|exists:priceds,id',
        ];
    }
}