<?php

namespace App\Http\Controllers;

use App\Http\Resources\DatePropertyBookingResource;
use App\Http\Resources\OwnerDashboardResource;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{

    // =============================== Booking Requests Method ==================================

    public function booking_requests()
    {
        $user = Auth::user();
        if($user->role === 'tenant'){
            return response()->json('you are tenant, Owners only', 403);
        }
        $bookings = Booking::whereHas('property', function ($query) use ($user) {
        $query->where('owner_id', $user->id);
        })->get();

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

        Notification::create([
            'user_id'   => $booking->tenant_id,
            'title'     => 'Booking status',
            'content'   => $request->bookings_status_check === 'completed' ?
                'Your booking has been approved from the owner' :
                'Sorry! Your booking has been rejected from the owner',
        ]);
        return response()->json(['message' => 'Booking status updated successfully', 'booking' => $booking], 200);
    }



}
