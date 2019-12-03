<?php

namespace App\Http\Requests\User;

use App\Rules\EmailAdminManager;
use Illuminate\Foundation\Http\FormRequest;

class VendorUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company' => 'required|max:255',
            'firstname' => 'required|max:50',
            'lastname' => 'nullable|max:50',
            'email' => ['nullable', 'email', 'max:100', new EmailAdminManager()],
            'phone' => 'required|max:20',
            'street_address1' => 'nullable|max:255',
            'street_address2' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'state' => 'nullable|max:255',
            'postal_code' => 'nullable|max:15|regex:/^\d{5}([\-]?\d{4})?$/',
            'website' => 'nullable|max:255',
            'fax_number' => 'nullable|max:50',
            'material_service' => 'nullable|array',
            'material_service.*' => 'string',
            'note' => 'nullable|string',
        ];
    }
}