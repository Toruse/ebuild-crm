<?php

namespace App\Http\Requests\Priced;

use Illuminate\Foundation\Http\FormRequest;

class PricedUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'type' => 'required|string|in:free,subscription',
            'default' => 'required|boolean',
            'repeat' => 'required|boolean',
            'period' => 'nullable|integer',
            'period_type' => 'nullable|string|in:day,week,month,year',
            'price' => 'nullable|string|max:25',
            'end_date' => 'nullable|date_format:d F Y',
            'note' => 'nullable|string',
        ];
    }
}