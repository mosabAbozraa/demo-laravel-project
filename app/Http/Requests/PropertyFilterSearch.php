<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyFilterSearch extends FormRequest
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
            'governorate_id'    => 'sometimes|integer|exists:governorates,id',
            'city_id'           => 'sometimes|integer|exists:cities,id',
            'min_price'         => 'sometimes|numeric|min:0',
            'max_price'         => 'sometimes|numeric|min:0',
            'rooms'             => 'sometimes|integer|min:1|max:15',
            'bath_rooms'        => 'sometimes|integer|min:1|max:15'
        ];
    }
}
