<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function add_property_to_owner(AddPropertyRequest $request){
        $user = Auth::user();
        // if($user->role === 'tenant'){
        //     $user->update(['role'=>'owner']);
        // }
        $validatedData = $request->validated();
        $validatedData['owner_id'] = $user->id;
        $property = Property::create($validatedData);
        
        foreach ($request->file('images') as $image){
            $path = $image->store('property_images','public');
            $property->images()->create([
                'path' => $path,
                'type' => 'image'
            ]);
        }
        return response()->json([
            'property' => $property,
            'images'   => $property->images()->get()->map(function ($imageUrl){
                return asset('storage/property_images'.$imageUrl->path);
            })
        ],201);
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

    public function getProperty($propertyId){
        $property = Property::with('owner')->find($propertyId);
        if(!$property){ 
            return response()->json('invalid id',400);
        }        
        return new PropertyResource($property);
    }
}
