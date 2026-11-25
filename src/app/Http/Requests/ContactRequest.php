<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $contact = $this->route('contact');

        return [
            "name" => ['required', 'string', 'min:6'],
            'contact' => [
                'required',
                'digits:9',
                Rule::unique('contacts', 'contact')->ignore($contact)->whereNull('deleted_at'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('contacts', 'email')->ignore($contact)->whereNull('deleted_at')
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Enter the name.',
            'name.min' => 'The name must be more than 5 characters long.',
            'contact.required' => 'Provide a contact.',
            'contact.digits' => 'The contact must contain exactly 9 digits.',
            'contact.unique' => 'This contact is already registered.',
            'email.required' => 'Enter your email address.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already registered.'
        ];
    }
}
