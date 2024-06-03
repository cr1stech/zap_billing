<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientAccountRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'total_amount' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'due_date' => 'required|date',
            'status' => ['required', Rule::in(['pending', 'partially_paid', 'paid', 'overdue'])],
        ];
    }
}
