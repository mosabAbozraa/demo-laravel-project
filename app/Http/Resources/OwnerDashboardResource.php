<?php

namespace App\Http\Resources;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use Carbon\Carbon;
class OwnerDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tenant_name' => User::find($this->tenant_id)->first_name,
            'tenant_phone' => User::find($this->tenant_id)->phone,
            'tenant_avatar' => User::find($this->tenant_id)->avatar,
            'property_description' => Property::find($this->property_id)->description,
            'number_of_days' => Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'booking_price' => $this->booking_price,
            'bookings_status_check' => $this->bookings_status_check,

        ];
    }
}
