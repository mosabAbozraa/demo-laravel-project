<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
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
}
