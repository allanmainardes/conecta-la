<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            '*.required' => 'Preencha todos os campos.',
            'name.string' => 'O nome deve ser um texto.',
            'email.string' => 'O email deve ser um texto.',
            'email.unique' => 'Este email já foi utilizado.',
            'email.email' => 'Por favor, insira um email válido.',
            'password.string' => 'A senha deve ser um texto.',
            'password.min' => 'A senha deve conter no mínimo 6 caracteres.',
        ];
    }
}
