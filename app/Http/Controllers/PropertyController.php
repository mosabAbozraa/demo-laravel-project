<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPropertyRequest;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Booking;
use App\Http\Requests\PropertyFilterSearch;
use App\Http\Resources\PropertyResource;
use App\Models\Governorate;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use function Symfony\Component\Clock\now;

class PropertyController extends Controller
{
    // ============================== Add Property Method ==================================

    public function add_property_to_owner(AddPropertyRequest $request){
        $user = Auth::user();
        if($user->role === 'tenant'){
            $user->update(['role'=>'owner']);
        }
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

    // =============================== Booking Method ==================================

public function booking(BookingRequest $request, $propertyId){
        $user = Auth::user();
        $validateData = $request->validated();

        $property = Property::find($propertyId);
        if(!$property){ 
            return response()->json('invalid id',400);
        }
        
        if ($user->id === $property->owner_id){
            return response()->json('you cannot book your own property',403);
        }
        
        $hasConflict = Booking::where('property_id',$property->id)->whereIn('bookings_status_check',['pending','completed'])
            ->where(function($query) use ($validateData){
                $query->where('start_date','<', $validateData['end_date'])
                      ->where('end_date','>',$validateData['start_date']);
            })->exists();
        if($hasConflict){
            return response()->json('the property is already booked for the selected dates',409);
        }
        $days = Carbon::parse($validateData['start_date'])->diffInDays(Carbon::parse($validateData['end_date']));
        $total_price = $days * $property->price_per_night;
        $booking = Booking::create([
            'tenant_id' => $user->id,
            'property_id' => $propertyId,
            'booking_price' => $total_price,
            'start_date' => $validateData['start_date'],
            'end_date' => $validateData['end_date'],
            'bookings_status_check' => 'pending_owner_approval'
        ]);
        return response()->json([
            'booking'=>$booking,
            'total_price'=>$total_price
        ],201);


        // $property->update(['current_status'=>'rented']);
        // $property->tenants()->attach($user->id);
        // return response()->json('done',200);
    }


// =============================== Update Booking Method ==================================

    public function edit_booking(BookingRequest $request, $bookingId)
{
    $user = Auth::user();
    $validatedData = $request->validated();

    $booking = Booking::find($bookingId);

    if (!$booking) {
        return response()->json(['message' => 'Booking not found'], 404);
    }

    if ($booking->tenant_id !== $user->id) {
        return response()->json(['message' => 'Unauthorized action'], 403);
    }

    if ($booking->bookings_status_check === 'canceled' || Carbon::parse($booking->end_date)->isPast()) {
         return response()->json(['message' => 'Cannot modify a completed or canceled booking'], 400);
    }

 
    $hasConflict = Booking::where('property_id', $booking->property_id)
        ->where('id', '!=', $booking->id) //  هون عم نتحقق انه ما يقارن مع نفس الحجز 
        ->whereIn('bookings_status_check', ['pending_owner_approval', 'completed'])
        ->where(function ($query) use ($validatedData) {
            $query->where('start_date', '<', $validatedData['end_date'])
                  ->where('end_date', '>', $validatedData['start_date']);
        })
        ->exists();

    if ($hasConflict) {
        return response()->json(['message' => 'The property is already booked for the new selected dates'], 409);
    }

    $property = $booking->property; 
    $days = Carbon::parse($validatedData['start_date'])->diffInDays(Carbon::parse($validatedData['end_date']));
    $newTotalPrice = $days * $property->price_per_night;

    $booking->update([
        'start_date'            => $validatedData['start_date'],
        'end_date'              => $validatedData['end_date'],
        'booking_price'         => $newTotalPrice,
        'bookings_status_check' => 'pending_owner_approval' 
    ]);

    return response()->json([
        'message' => 'Booking updated and pending owner approval',
        'booking' => $booking
    ], 200);
}

// =============================== Cancel Booking Method ==================================

public function cancel_booking($bookingId)
{
    $user = Auth::user();
    $booking = Booking::find($bookingId);

    if (!$booking) {
        return response()->json(['message' => 'Booking not found'], 404);
    }

    if ($booking->tenant_id !== $user->id) {
        return response()->json(['message' => 'Unauthorized action'], 403);
    }

    if (Carbon::parse($booking->start_date)->isPast() && $booking->bookings_status_check === 'completed') {
        return response()->json(['message' => 'Cannot cancel a past booking'], 400);
    }

    $booking->update([
        'bookings_status_check' => 'canceled'
    ]);

    return response()->json(['message' => 'Booking canceled successfully'], 200);
}

// =============================== My Bookings Method ==================================
public function myBookings()
{
    $user = Auth::user();

    $bookings = Booking::where('tenant_id', $user->id)
        ->with(['property' => function($query) {
            $query->select('id', 'governorate_id', 'city_id', 'price_per_night', 'rooms', 'bath_rooms', 'area'); 
        }])->orderBy('created_at', 'desc')->get();

    return response()->json([
        'count' => $bookings->count(),
        'bookings' => $bookings
    ], 200);
}

// ==================================Admin Controller Methods==================================
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

    // =================================== Filter Search ===================================
    public function search(PropertyFilterSearch $request){
        $filters = $request->validated();
        $properties = Property::query()->filter($filters)->get();

        return response()->json($properties);
    }

    public function rate_property(Request $request, $propertyId){
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $property = Property::find($propertyId);
        if(!$property){
            return response()->json('Property not found',404);
        }
        
        $newRating = $request->rating;
        $totalRating = ($property->average_rating+$newRating)/($property->number_of_ratings + 1);
        $property->average_rating = $totalRating;
        $property->number_of_ratings++;
        $property->save();
        return response()->json('Rating submitted successfully',201);
    }
}
