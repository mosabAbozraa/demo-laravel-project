<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userName = $this->first_name . ' ' . $this->last_name;
        $userAvatar = $this->avatar;
        $userDateOfBirth = $this->date_of_birth;
        $userPhone = $this->phone;
        $userNumberOfProperties = $this->ownedProperties()->count();
        $userNumberOfRentedProperties = $this->rentedProperties()->count();
        return [
            'name' => $userName,
            'avatar' => $userAvatar,
            'date_of_birth' => $userDateOfBirth,
            'phone' => $userPhone,
            'number_of_properties' => $userNumberOfProperties,
            'number_of_rented_properties' => $userNumberOfRentedProperties
        ];
    }
}
