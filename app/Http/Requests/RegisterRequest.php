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
                'name' =>['required','min:5','max:15'],
                'email' => ['required','email'],
                'password' => ['required','min:5']
        ];
    }

    public function messages(): array
    {
        return [
                'required'    => ':attribute must be provided.',
                'min'         => 'minimum :attribute characters required',
                'max'         => 'A maximum of :attribute characters is required'
        ];
    }

    public function attributes(): array
    {
        return [
            'name'     => 'Name',
            'email'    => 'Email',
            'password' => 'Password',
        ];
    }
}
