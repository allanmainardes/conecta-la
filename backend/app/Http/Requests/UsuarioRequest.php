<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
        $rules = [
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'senha' => 'required|string|min:6',
        ];

        if ($this->isMethod('post')) {
            $rules['email'] .= '|unique:usuarios';
        } elseif ($this->isMethod('put')) {
            $rules['email'] .= '|unique:usuarios,email,' . $this->id;
        }

        return $rules;
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
            'nome.string' => 'O nome deve ser um texto.',
            'sobrenome.string' => 'O sobrenome deve ser um texto.',
            'email.string' => 'O email deve ser um texto.',
            'email.unique' => 'Este email já foi utilizado.',
            'email.email' => 'Por favor, insira um email válido.',
            'senha.string' => 'A senha deve ser um texto.',
            'senha.min' => 'A senha deve conter no mínimo 6 caracteres.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'email' => strtolower($this->email),
            'nome' => ucfirst($this->nome),
            'sobrenome' => ucfirst($this->sobrenome),
        ]);
    }
}
