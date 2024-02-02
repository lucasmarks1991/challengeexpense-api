<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'description' => 'required|string|max:191',
            'occurred_date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'currency' => 'required|string|size:3',
            'value' => 'required|numeric|min:0.01',
        ];
    }
}
