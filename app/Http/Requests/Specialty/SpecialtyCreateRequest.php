<?php

namespace App\Http\Requests\Specialty;

use Illuminate\Foundation\Http\FormRequest;

class SpecialtyCreateRequest extends FormRequest
{
    /**
     * @var SpecialtyBaseRequest
     */
    private $baseRequest;

    /**
     * Request constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseRequest = new SpecialtyBaseRequest;
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
    public function rules(): array
    {
        return $this->baseRequest->rules();
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return $this->baseRequest->messages();
    }
}
