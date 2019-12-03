<?php

namespace App\Http\Requests\User;

use App\Rules\EmailAdminManager;
use Illuminate\Foundation\Http\FormRequest;

class ProjectManagerCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => 'required|max:50',
            'lastname' => 'nullable|max:50',
            'email' => 'nullable|email|max:100|unique:users',
            'phone' => 'required|max:20|unique:users',
            'street_address1' => 'nullable|max:255',
            'street_address2' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'state' => 'nullable|max:255',
            'postal_code' => 'nullable|max:15|regex:/^\d{5}([\-]?\d{4})?$/',
            'active' => 'boolean',
            'note' => 'nullable|string',
            'task_ids' => 'array',
            'task_ids.*' => 'exists:tasks,id',
        ];
    }
}