<?php

namespace App\Http\Requests\ScheduleTask;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleTaskChangeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'schedule' => 'nullable|exists:schedules,id',
            'reminder' => 'nullable|exists:view_contacts,id',
            'type' => 'required|string|max:255',
            'color' => 'regex:/^#[a-zA-Z0-9]{6}$/i',
            'start_date' => 'date_format:d F Y',
            'end_date' => 'date_format:d F Y',
            'note' => 'nullable|string',
            'bind_users' => 'nullable|array',
            'bind_users.*' => 'exists:users,id',
        ];
    }
}