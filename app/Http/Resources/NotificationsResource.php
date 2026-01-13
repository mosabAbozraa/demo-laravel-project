<?php

namespace App\Http\Resources;

use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if($this->title === 'Admin response')
        {
        $senderName = 'Admin';
         return [
            'sender' => $senderName,
            'avatar' => null,
            'title'     => $this->title,
            'content'    => $this->content,
            'status'    => $this->is_seen
         ];
        }
        $book = Booking::find($this->booking_id);
        $owner_name = $book->property->owner->first_name.' '.$book->property->owner->last_name;
        $owner_photo = $book->property->owner->avatar;

        return [
            'sender' => $owner_name,
            'avatar' => $owner_photo,
            'title'     => $this->title,
            'content'    => $this->content,
            'status'    => $this->is_seen
        ];
    }

}
