<?php

namespace App\Http\Resources;

use App\Models\Booking;
use App\Models\Conversation;
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

        //////////////////////////First type of notification: Admin Response//////////////////////////
        if($this->title === 'Admin Response')
        {
            $senderName = 'Admin';
            return [
            'sender' => $senderName,
            'avatar' => "Unknown",
            'title'     => $this->title,
            'content'    => $this->content,
            'status'    => $this->is_seen
            ];
        }
         ////////////////////////Second type of notification: Chat Message//////////////////////////
         else if ($this->title === 'Chat Message'){
            $book = Booking::find($this->booking_id);if(!$book){
                return [
                    'sender' => 'Unknown',
                    'avatar' => "null",
                    'title'     => $this->title,
                    'content'    => $this->content,
                    'status'    => $this->is_seen
                    ];
            }
            if($this->user_id === $book->tenant_id)
            {
                $senderName = $book->property->owner->first_name.' '.$book->property->owner->last_name;
                $avatar = $book->property->owner->avatar;
                $conversation_id = Conversation::where('tenant_id', $book->tenant_id)
                                        ->where('property_id', $book->property_id)
                                        ->first()->id;
                return [
                'sender' => $senderName,
                'avatar' => $avatar,
                'title'     => $this->title,
                'content'    => $this->content,
                'status'    => $this->is_seen,
                'conversation_id' => $conversation_id
                ];
            }elseif($this->user_id === $book->property->owner_id){
                $senderName = $book->tenant->first_name.' '.$book->tenant->last_name;
                $avatar = $book->tenant->avatar;
                $conversation_id = Conversation::where('tenant_id', $book->tenant_id)
                                        ->where('property_id', $book->property_id)
                                        ->first()->id;
                return [
                'sender' => $senderName,
                'avatar' => $avatar,
                'title'     => $this->title,
                'content'    => $this->content,
                'status'    => $this->is_seen,
                'conversation_id' => $conversation_id

                ];
            }
            }
        //////////////////////////Third type of notification: Booking Status Update//////////////////////////
        $book = Booking::find($this->booking_id);
        $owner_name = $book->property->owner->first_name.' '.$book->property->owner->last_name;
        $owner_photo = $book->property->owner->avatar;

        return [
            'sender' => $owner_name,
            'avatar' => $owner_photo,
            'title'     => $this->title,
            'content'    => $this->content,
            'status'    => $this->is_seen,
            'booking_id' => $this->booking_id
        ];
    }

}
