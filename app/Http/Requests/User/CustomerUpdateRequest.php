<?php

namespace App\Http\Requests\User;

use App\Rules\EmailAdminManager;
use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'phone' => 'required|max:20',
            'street_address1' => 'nullable|max:255',
            'street_address2' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'state' => 'nullable|max:255',
            'postal_code' => 'nullable|max:15|regex:/^\d{5}([\-]?\d{4})?$/',
            'project_manager' => 'nullable|exists:users,id',
            'source' => 'nullable|exists:sources,id',
            'project_type' => 'nullable|exists:project_types,id',
            'status' => 'in:open,sold,lost,complete,no_opportunity',
            'note' => 'nullable|string',
        ];
    }
}