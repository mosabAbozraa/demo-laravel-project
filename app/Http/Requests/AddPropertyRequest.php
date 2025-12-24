<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class AddPropertyRequest extends FormRequest
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
            'images'            => 'array',//add required here
            'images.*'          => 'image|mimes:jpg,png,jpeg|max:2048',  // 2 MB
            'governorate_id'    => 'required|integer|exists:governorates,id',
            'city_id'           => [
                'required',
                'integer',
                Rule::exists('cities','id')->where(function ($q){
                    $q->where('governorate_id',$this->governorate_id);
                })],
            'price_per_night'   => 'required|numeric',
            'description'       => 'sometimes|max:300',
            'area'              => 'required|numeric',
            'rooms'             => 'required|integer|min:1|max:20',
            'bath_rooms'        => 'required|integer|min:0|max:20'
        ];
    }
}
