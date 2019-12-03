<?php

namespace App\Http\Requests\User;

use App\Rules\EmailAdminManager;
use Illuminate\Foundation\Http\FormRequest;

class ContractorUpdateRequest extends FormRequest
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
            'email' => ['nullable', 'email', 'max:100', new EmailAdminManager()],
            'password' => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable|min:6',
            'phone' => 'required|max:20',
            'street_address1' => 'nullable|max:255',
            'street_address2' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'state' => 'nullable|max:255',
            'postal_code' => 'nullable|max:15|regex:/^\d{5}([\-]?\d{4})?$/',
            'skill_specialty' => 'nullable|array',
            'skill_specialty.*' => 'string',
            'note' => 'nullable|string',
        ];
    }
}