<?php

namespace App\Http\Requests\ScheduleTask;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleTaskEventResizeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d',
        ];
    }
}