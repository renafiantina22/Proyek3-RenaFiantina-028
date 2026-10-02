<?php

namespace App\Http\Requests;

use App\Models\Activity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'activity_date' => ['required', 'date'],
            'start_at' => ['required', 'date'],

            'end_at' => [
                'required',
                'date',
                'after_or_equal:start_at',
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:500',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'code' => [
                'required',
                'string',
                'max:30',
                'unique:activities,code',
            ],

            'status' => [
                'required',
                Rule::in(Activity::STATUSES),
            ],
        ];
    }
}
