<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DatePropertyBookingResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'booking_id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];
    }
}
