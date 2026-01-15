<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\Governorate;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
        $governorate_name = Governorate::find($property->governorate_id)->name;
        $city_name = City::find($property->city_id)->name;
        $title = Str::words($property->description, 3, '...');
        return [
            'Booking_ID' => $this->id,
            'Owner Name' => $owner_name,
            'Owner Photo' => 'storage/'.$owner_photo,
            'Owner Phone' => $owner_phone,
            'Property Rate' => $property->average_rating,
            'Property Id' => $this->property_id,
            'Property_Title' => $title,
            'Location'   => $governorate_name.'/'.$city_name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'number_of_days' => Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)),
            'booking_rate'  => $this->booking_rate,
            'booking_price' => $this->booking_price,
            'bookings_status_check' => $this->bookings_status_check,
        ];
    }
}
