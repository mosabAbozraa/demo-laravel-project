<?php

namespace App\Http\Resources;

use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyReservationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $property = Property::find($this->property_id);
        $owner_name = User::find($property->owner_id)->first_name;
        $owner_photo = User::find($property->owner_id)->avatar;
        $owner_phone = User::find($property->owner_id)->phone;
        return [
            'Owner Name' => $owner_name,
            'Owner Photo' => $owner_photo,
            'Owner Phone' => $owner_phone,
            'Property_Description' => $property->description,
            'Property_Rooms' => $property->rooms,
            'Property_Area' => $property->area,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'number_of_days' => Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)),
            'booking_price' => $this->booking_price,
            'bookings_status_check' => $this->bookings_status_check,
        ];
    }
}
