<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdateRequest extends FormRequest
{
    /**
     * @var ScheduleBaseRequest
     */
    private $baseRequest;

    /**
     * Request constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseRequest = new ScheduleBaseRequest;
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
    public function rules(array $additionalData): array
    {
        return $this->baseRequest->rules($additionalData);
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return $this->baseRequest->messages();
    }
}
