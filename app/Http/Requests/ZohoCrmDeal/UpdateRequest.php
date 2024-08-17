<?php

namespace App\Http\Requests\ZohoCrmDeal;

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
            'dealName' => ['required', 'string', 'max:50'],
            'stage' => ['required', 'string', 'max:50'],
            'accountId' => ['required', 'string', 'min:1'],

        ];
    }

    /**
     * Get the custom validation messages for the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'dealName.required' => 'The Deal Name field is required.',
            'dealName.string' => 'The Deal Name must be a string.',
            'dealName.max' => 'The Deal Name may not be greater than 50 characters.',
            'stage.required' => 'The Stage field is required.',
            'stage.string' => 'The Stage must be a string.',
            'stage.max' => 'The Stage may not be greater than 50 characters.',
            'accountId.required' => 'The Account ID field is required.',
            'accountId.string' => 'The Account ID must be a string.',
            'accountId.min' => 'The Account ID must be at least 1 character.',
        ];
    }
}
