<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function create_property_for_owner(Request $request){
        $user = User::find($request->owner_id);
        if($user->role === 'tenant'){
            $user->update(['role'=>'owner']);
        }
        $property = Property::create([
            'owner_id' => $request->owner_id,
            'governorate' => $request->governorate,
            'city'=>$request->city,
            'price_per_night'=>$request->price_per_night,
            'description'=>$request->description,
            'area' => $request->area,
            'rooms' =>$request->rooms,
            'bath_rooms' =>$request->bath_rooms
        ]);
        return response()->json($property,201);
    }

    public function booking(Request $request,$propertyId){
        $property = Property::find($propertyId);
        if(!$property) return response()->json('cant enter',400);
        $property->tenants()->attach($request->tenant_id);
        return response()->json('done',200);
    }
}
