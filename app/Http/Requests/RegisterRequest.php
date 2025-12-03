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
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'phone'             => 'required|string|unique:users,phone',
            'password'          => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'complexity:letters,numbers,symbols'
            ],
            'personal_image'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth'     => 'required|date|date_format:Y-m-d',
        ];
    }
}
