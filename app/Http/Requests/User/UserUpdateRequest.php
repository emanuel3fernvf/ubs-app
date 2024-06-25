<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * @var UserBaseRequest
     */
    private $baseRequest;

    /**
     * Request constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseRequest = new UserBaseRequest;
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
        int $userId,
        array $positions,
    ): array {
        $rules = $this->baseRequest->rules($positions);

        $rules['email'][] = Rule::unique('users')->ignore($userId);
        $rules['password'][] = 'nullable';

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return $this->baseRequest->messages();
    }
}
