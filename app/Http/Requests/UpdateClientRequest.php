<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
        $clientId = $this->route('id');

        return [
            'name' => 'sometimes|string|max:255',
            'phone_number' => [
                'sometimes',
                'string',
                'max:20',
                Rule::unique('clients')->ignore($clientId),
            ],
            'status' => 'sometimes|in:active,inactive',
        ];
    }
}
