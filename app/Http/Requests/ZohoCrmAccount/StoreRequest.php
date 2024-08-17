<?php

namespace App\Http\Requests\ZohoCrmAccount;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'accountName' => ['required', 'max:50'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'website' => [
                'required',
                'regex:/^(https?:\/\/)?(www\.)?[-a-z0-9]+(\.[a-z]{2,})(\/[-a-z0-9+&@#\/%?=~_|]*)?$/i',
            ],
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'accountName.required' => 'The account name is required.',
            'accountName.max' => 'The account name may not be greater than 50 characters.',

            'website.required' => 'The website field is required.',
            'website.regex' => 'Please provide a valid URL with a domain and domain extension ( e.g., .com, .net).',

            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number format is invalid.',
            'phone.min' => 'The phone number must be at least 10 digits.',
        ];
    }
}
