<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function add_property_to_owner(Request $request){
        $user = Auth::user();
        // if($user->role === 'tenant'){
        //     $user->update(['role'=>'owner']);
        // }

        $property = Property::create([
            'owner_id'          => $user->id,  
            'governorate'       => $request->governorate,
            'city'              =>$request->city,
            'price_per_night'   =>$request->price_per_night,
            'description'       =>$request->description,
            'area'              => $request->area,
            'rooms'             =>$request->rooms,
            'bath_rooms'        =>$request->bath_rooms
        ]);
        return response()->json($property,201);
    }

    public function booking($propertyId){
        $user = Auth::user();
        
        $property = Property::find($propertyId);
        if(!$property){ 
            return response()->json('invalid id',400);
        }
        
        if ($user->id === $property->owner_id){
            return response()->json('you cannot book your own property',403);
        }
        
        // maybe here we can but a validation for the dates 
        $property->update(['current_status'=>'rented']);
        $property->tenants()->attach($user->id);
        return response()->json('done',200);
    }

    public function show_all_properties(){
        $number_of_properties = Property::count();
        return response()->json([
            'total_properties'=>$number_of_properties,
            'properties'=>Property::all()],
            200);
    }
}
