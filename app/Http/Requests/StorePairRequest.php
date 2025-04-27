<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePairRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'devise_from_id' => 'required|exists:currencies,id|different:devise_to_id',
            'devise_to_id' => 'required|exists:currencies,id',
            'rate' => 'required|numeric|min:0',
        ];
    }
}
