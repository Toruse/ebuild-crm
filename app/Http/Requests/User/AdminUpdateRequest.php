<?php

namespace App\Http\Requests\User;

use App\Rules\EmailAdminManager;
use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => 'required|max:50',
            'email' => 'required|email|max:100|unique:users,email,'.$this->admin,
            'phone' => 'required|max:20|unique:users,phone,'.$this->admin,
        ];
    }
}