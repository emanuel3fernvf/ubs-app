<?php

namespace App\Http\Requests\Professional;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfessionalBaseRequest extends FormRequest
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
    public function rules(array $users, array $specialties): array
    {
        return [
            'crm' => 'required',
            'user_id' => ['required', 'integer', Rule::in($users)],
            'specialty_id' => ['required', 'integer', Rule::in($specialties)],
            'status' => ['required', Rule::in('active', 'inactive')],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return __('messages_validation.professional.base');
    }
}
