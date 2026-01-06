<?php

namespace App\Http\Resources;

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
        return [
            'tenant id' => $this->user_id,
            'title'     => $this->title,
            'conent'    => $this->content,
            'status'    => $this->is_seen
        ];
    }
}
