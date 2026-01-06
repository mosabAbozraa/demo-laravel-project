<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password;

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
            'password' => [
            'required',
            'string'
            // Password::min(8)
            //     ->letters()
            //     ->mixedCase()
            //     ->numbers()
            //     ->symbols(),
            // 'confirmed'
        ],
            'avatar'            => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5 MB
            'id_photo'          => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5 MB
            'date_of_birth'     => 'required|date|date_format:Y-m-d',
        ];
    }
}
