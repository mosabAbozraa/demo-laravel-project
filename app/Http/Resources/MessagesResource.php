<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
  
            'contents' => $this->contents,
            'isMe' => $this->sender_id === $request->user()->id, 
            'sent at' => $this->created_at->format('h:i A, d M Y'),

        ];
    }
}
