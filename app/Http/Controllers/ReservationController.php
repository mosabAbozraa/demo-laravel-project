<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\DatePropertyBookingResource;
use App\Http\Resources\MyReservationsResource;
use App\Http\Resources\OwnerDashboardResource;
use App\Http\Resources\PropertyResource;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
// use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use function Symfony\Component\Clock\now;
use App\Models\User;

class ReservationController extends Controller
{

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
            'bookings_status_check' => 'pending'
        ]);
        return response()->json([
            'booking'=>$booking,
            'total_price'=>$total_price
        ],201);


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
            ->whereIn('bookings_status_check', ['pending', 'completed'])
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
        $newTotalPrice = $days * $property->price_per_night; // here we should put ($days+1)

        $booking->update([
            'start_date'            => $validatedData['start_date'],
            'end_date'              => $validatedData['end_date'],
            'booking_price'         => $newTotalPrice,
            'bookings_status_check' => 'pending'
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
    public function tenant_bookings()
    {
        $user = Auth::user();
        $bookings = Booking::where('tenant_id', $user->id)->with('property')->get();
        return MyReservationsResource::collection($bookings);
    }

    public function show_all_bookings_for_one_property($propertyId)
    {
        $property = Property::find($propertyId);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $bookings = Booking::where('property_id', $propertyId)->whereIn('bookings_status_check',['pending','completed'])->with('tenant')->get();

        return DatePropertyBookingResource::collection($bookings);
    }

    // =============================== Owner Management Method ==================================

    // ================================Booking Requests Method================================================
    public function booking_requests()
    {
        $user = Auth::user();
        if($user->role === 'tenant'){
            return response()->json('you are tenant, Owners only', 403);
        }
        $bookings = Booking::whereHas('property', function ($query) use ($user) {
        $query->where('owner_id', $user->id);
        })
         // here we should added resource for the output---> لك مو تكرم عينك كم مصعب عنا لحنا
         ->get();

         return OwnerDashboardResource::collection($bookings);
    }

    // =============================== Update Booking Request Status Method ==================================
    public function update_booking_status(Request $request, $bookingId)
    {
        $user = Auth::user();
        $request->validate([
            'bookings_status_check' => 'required|in:completed,canceled'
        ]);

        $booking = Booking::find($bookingId);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $property = $booking->property;
        if ($property->owner_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized action'], 403);
        }

        if ($booking->bookings_status_check !== 'pending') {// التحقق  اذا كان المالك نازل يجدبها لما لا
            return response()->json(['message' => 'Only pending bookings can be updated ,صاحيلك لاتجدبها'], 400);
        }

        $booking->update([
            'bookings_status_check' => $request->bookings_status_check
        ]);

        //لك مصعب كأن مالها داعي يكون للعقار حالة لان انا من الخرج عرفت انه الو حالة مالنا مستخدمينها ابدا
        $property->update([
            'current_status' => $request->bookings_status_check === 'completed' ? 'rented' : 'unrented'
        ]);

        return response()->json(['message' => 'Booking status updated successfully', 'booking' => $booking], 200);
    }
}
