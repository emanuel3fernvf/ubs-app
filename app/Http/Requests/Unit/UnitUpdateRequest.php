<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;

class UnitUpdateRequest extends FormRequest
{
    /**
     * @var UnitBaseRequest
     */
    private $baseRequest;

    /**
     * Request constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseRequest = new UnitBaseRequest;
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
