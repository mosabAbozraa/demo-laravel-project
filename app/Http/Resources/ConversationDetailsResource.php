<?php

namespace App\Http\Resources;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $senderName=null;
        $senderAvatar=null;
        $receiverName=null;
        $receiverAvatar=null;
        if($this->tenant_id === $request->user()->id){
            $senderName = User::find($this->tenant_id)->first_name ." ". User::find($this->tenant_id)->last_name;
            $senderAvatar = User::find($this->tenant_id)->avatar;
            $receiverName = User::find($this->owner_id)->first_name ." ". User::find($this->owner_id)->last_name;
            $receiverAvatar = User::find($this->owner_id)->avatar;
            $receiverPhone = User::find($this->owner_id)->phone;
        }else{
            $senderName = User::find($this->owner_id)->first_name ." ". User::find($this->owner_id)->last_name;
            $senderAvatar = User::find($this->owner_id)->avatar;
            $receiverName = User::find($this->tenant_id)->first_name ." ". User::find($this->tenant_id)->last_name;
            $receiverAvatar = User::find($this->tenant_id)->avatar;
            $receiverPhone = User::find($this->tenant_id)->phone;
        }
        $propertyImage = Property::find($this->property_id)->images()->first()->path;
        $title = Property::find($this->property_id)->description;
        $pricePerNight = Property::find($this->property_id)->price_per_night;

    
        return [
            'sender name' => $senderName,
            'sender avatar' => $senderAvatar,
            'receiver name' => $receiverName,
            'receiver avatar' => $receiverAvatar,
            'receiver phone number' => $receiverPhone,
            'Property information' => [
                'image' => 'storage/' . $propertyImage,
                'title' => $title,
                'price per night' => $pricePerNight,
            ]
        ];
    }
}
