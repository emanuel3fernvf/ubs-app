<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientBaseRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|max:50',
            'cpf' => 'required',
            'birth_date' => 'required|date',
            'phone' => 'required',
            'status' => ['required', Rule::in('active', 'inactive')],
            'address_street' => 'required|max:50',
            'address_number' => 'required|int',
            'address_complement' => 'required|max:50',
            'address_neighborhood' => 'required|max:50',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return __('messages_validation.patient.base');
    }
}
