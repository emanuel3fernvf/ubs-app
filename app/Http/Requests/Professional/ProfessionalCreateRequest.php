<?php

namespace App\Http\Requests\Professional;

use Illuminate\Foundation\Http\FormRequest;

class ProfessionalCreateRequest extends FormRequest
{
    /**
     * @var ProfessionalBaseRequest
     */
    private $baseRequest;

    /**
     * Request constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseRequest = new ProfessionalBaseRequest;
    }

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
    public function rules(
        array $users,
        array $specialties,
        array $positions,
    ): array {
        return $this->baseRequest->rules($users, $specialties, $positions);
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return $this->baseRequest->messages();
    }
}
