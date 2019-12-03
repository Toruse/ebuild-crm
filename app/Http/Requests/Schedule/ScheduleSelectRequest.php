<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleSelectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_date' => 'required|date_format:d F Y',
            'schedule' => 'required|exists:schedules,id',
            'project' => 'nullable|exists:projects,id',
        ];
    }
}