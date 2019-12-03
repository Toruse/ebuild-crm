<?php

namespace App\Http\Requests\Project;

use App\Rules\EmailAdminManager;
use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer' => 'exists:users,id',
            'price' => 'nullable|regex:/^[\,\d]+\.\d{2}+$/',
            'type' => 'exists:project_types,id',
            'street_address1' => 'nullable|max:255',
            'street_address2' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'state' => 'nullable|max:255',
            'postal_code' => 'nullable|max:15|regex:/^\d{5}([\-]?\d{4})?$/',
            'project_manager' => 'exists:users,id',
            'color' => 'regex:/^#[a-zA-Z0-9]{6}$/i',
            'start_date' => 'date_format:d F Y',
            'end_date' => 'nullable|date_format:d F Y',
        ];
    }
}