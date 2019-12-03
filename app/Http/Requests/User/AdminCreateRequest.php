<?php

namespace App\Http\Requests\User;

use App\Rules\EmailAdminManager;
use Illuminate\Foundation\Http\FormRequest;

class AdminCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => 'required|max:50',
            'email' => 'required|email|max:100|unique:users',
            'phone' => 'required|max:20|unique:users',
            'password' => 'min:6|confirmed',
            'password_confirmation' => 'min:6',
        ];
    }
}