<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScheduleBaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(array $additionalData): array
    {
        return [
            'professional_id' => [
                'required',
                'integer',
                Rule::in($additionalData['professional_id']),
            ],
            'patient_id' => [
                'required',
                'integer',
                Rule::in($additionalData['patient_id']),
            ],
            'date' => 'required|date',
            'time' => 'required|date_format:H:i|before_or_equal:17:00|after_or_equal:07:00',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return __('messages_validation.schedule.base');
    }
}
