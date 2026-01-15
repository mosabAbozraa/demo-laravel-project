<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyConversationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * conversation id
     * last message contents
     * last message sent at
     * receiver name
     * receiver avatar
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $receiverName = null;
        $receiverAvatar = null;
        if($this->tenant_id === $request->user()->id){
            $receiverName = $this->owner->first_name ." ". $this->owner->last_name;
            $receiverAvatar = $this->owner->avatar;
        }else{
            $receiverName = $this->tenant->first_name ." ". $this->tenant->last_name;
            $receiverAvatar = $this->tenant->avatar;
        }
        $lastMessage = $this->messages()->latest()->first();
        $lastMessageSentAt = $lastMessage ? $lastMessage->created_at->format('Y-m-d') : null;
        
        return [
            'conversation id' => $this->id,
            'last message contents' => $lastMessage ? $lastMessage->contents : null,
            'last message sent at' => $lastMessageSentAt,
            'receiver name' => $receiverName,
            'receiver avatar' => $receiverAvatar,
        ];
    }
}
