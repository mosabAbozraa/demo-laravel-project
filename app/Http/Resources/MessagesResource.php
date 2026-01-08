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
        $firstName = User::find($this->sender_id)->first_name;
        return [
            'Message ID' => $this->id,
            'sender name' => $firstName,
            'contents' => $this->contents,
            'sent at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
