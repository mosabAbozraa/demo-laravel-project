<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Governorate; // 1. تأكد من استدعاء الموديل هنا

class AddPropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'images'          => 'required|array',
            'images.*'        => 'image|mimes:jpg,png,jpeg|max:5120',
            'governorate'     => 'required|string|exists:governorates,name',
            'city'            => [
                'required',
                'string',
                Rule::exists('cities', 'name')->where(function ($query) {
                    
                    $governorateName = $this->governorate;
                    $governorate = Governorate::where('name', $governorateName)->first();

                    if ($governorate) {
                        return $query->where('governorate_id', $governorate->id);
                    }
                    return $query->where('id', 0);//شرط مستحيل مشان اذا فشلت المحافظة ما يرجع ولا مدينة
                }),
            ],

            'price_per_night' => 'required|numeric',
            'description'     => 'sometimes|max:300',
            'area'            => 'required|numeric',
            'rooms'           => 'required|integer|min:1|max:20',
            'bath_rooms'      => 'required|integer|min:0|max:20'
        ];
    }
}