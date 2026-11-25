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
            'name.required' => 'Informe o nome.',
            'name.min' => 'O nome deve ter mais de 5 caracteres.',
            'contact.required' => 'Informe um contato.',
            'contact.digits' => 'O contato deve conter exatamente 9 dígitos.',
            'contact.unique' => 'Este contato já está cadastrado.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.'
        ];
    }
}
