<?php

namespace App\Http\Resources;

use Doctrine\Common\Lexer\Token;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = $this->createToken('auth_token')->plainTextToken;
        return [
            'token'         => $token,
            'first name'    => $this->first_name,
            'last name'     => $this->last_name,
            'phone'         => $this->phone,
            'avatar'        => $this->avatar,
            // 'date'          => $this->data_of_birth->format('Y-m-d')
        ];
    }
}
