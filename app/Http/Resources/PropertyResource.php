<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\Governorate;
use App\Models\User;
use Dom\Text;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'governorate'       => Governorate::find($this->governorate_id)->name,
            'city'              => City::find($this->city_id)->name,
            // 'title'             => $this->getWords($this->description),
            'price per night'   => $this->price_per_night,
            'description'       => $this->description,
            'area'              => $this->area,
            'rooms'             => $this->rooms,
            'bath rooms'        => $this->bath_rooms,
            'rating'            => $this->average_rating,
            'date'              => $this->created_at->format('Y-m-d'),
            'images'            => $this->images()->get()->map(function ($img){
                return asset('storage/'.$img->path);}),
            'owner information' => new OwnerResource($this->whenLoaded('owner'))
        ];
    }

    // public function getWords(Text $text){
    //     $title = '';
    //     for($i=0;$i<count($text);$i++){

    //     }
    // }
}
