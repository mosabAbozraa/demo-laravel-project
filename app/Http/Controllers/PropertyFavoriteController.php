<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoritesResource;
use App\Http\Resources\OwnerResource;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Models\PropertyFavorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Support\Facades\Auth;

class PropertyFavoriteController extends Controller
{
    //============================== add property to favorites ====================
    public function add_property_to_favorites($propertyId){
        $property = Property::with('owner')->find($propertyId);
        if(!$property){
            return response()->json('Property not found', 404);
        }

        $user = Auth::user();
        // if ($user->id === $property->owner_id){
        //     return response()->json('you cannot add your own property to favorites',403);
        // }

            $property->user_favorites()->attach($user->id);
            return response()->json([
                'message'   => 'property added to favorites',
                'property'  => new PropertyResource($property)
            ],200);
    }

    //============================== show properties list ============================
    public function show_my_favorites(){
        $user = Auth::user();
        $favoritesList = PropertyFavorite::where('user_id',$user->id)->with('favorites.owner')->orderBy('created_at','desc')->get();
        return response()->json([
            'count'     => $favoritesList->count(),
            'favorites' => FavoritesResource::collection($favoritesList)
        ], 200);
    }

}
