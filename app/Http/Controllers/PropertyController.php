<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPropertyRequest;
use App\Http\Requests\PropertyFilterSearch;
use App\Http\Resources\PropertyResource;
use App\Models\Booking;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Property;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    // ============================== Add Property Method ==================================
    public function add_property_to_owner(AddPropertyRequest $request){
      $user = Auth::user();
    if($user->role === 'tenant'){
        $user->update(['role'=>'owner']);
    }
    $validatedData = $request->validated();

    $governorate = Governorate::where('name', $request->governorate)->first();

    $city = City::where('name', $request->city)
                ->where('governorate_id', $governorate->id)
                ->first();

    unset($validatedData['governorate']);
    unset($validatedData['city']);

    $validatedData['governorate_id'] = $governorate->id;
    $validatedData['city_id'] = $city->id;
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
            'images'   => $property->images()->get()->map(function ($img){
                return 'storage/'.$img->path;
            })
        ],201);
    }

    // =============================== Show All Properties Method ==================================
    public function show_all_properties(){
        $number_of_properties = Property::count();
        $properties = Property::with('owner')->get();
        return response()->json([
           'total_properties'=>$number_of_properties,
            'properties'=>PropertyResource::collection($properties)],
            200);
    }

    // =============================== Get One Property Method ==================================
    public function getProperty($propertyId){
        $property = Property::with('owner')->find($propertyId);
        if(!$property){
            return response()->json('invalid id',400);
        }
        return new PropertyResource($property);
    }

    // =================================== Filter Search ===================================
    public function search(PropertyFilterSearch $request){
        $filters = $request->validated();
        $properties = Property::query()->filter($filters)->get();

        return response()->json(['search results' => $properties->count() ,'properties'=>$properties]);
    }

    // =============================== Rate Property ==================================
    public function roundToHalf($number) {
        return round($number * 2) / 2;
    }

    public function rate_property(Request $request, $propertyId){
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);
        $user=Auth::user();
        $property = Property::find($propertyId);
        if(!$property){
            return response()->json('Property not found',404);
        }

        $newRating = $request->rating;
        $totalRating = ($property->average_rating*$property->number_of_ratings + $newRating)/($property->number_of_ratings+1);            $property->average_rating = $this->roundToHalf($totalRating);
        $property->number_of_ratings += 1;
        $property->save();

        // $booking = $property->tenants()->where('tenant_id',$user->user_id)->first();
        $booking = Booking::where('property_id',$property->id)->where('tenant_id',$user->id);
        $booking->update(['booking_rate'=>$totalRating]);

        return response()->json(['message' => 'Rating submitted successfully', 'property rate' => $property->average_rating],201);

    }
}
