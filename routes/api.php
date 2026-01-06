<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyFavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    //=================================== Properties ===================================

    Route::group(['prefix'=>'properties'],function(){
        Route::post('add',[PropertyController::class,'add_property_to_owner']);

        Route::get('showAll',[PropertyController::class,'show_all_properties']);

        Route::get('showOne/{propertyId}',[PropertyController::class,'getProperty']);

        Route::get('filterSearch',[PropertyController::class,'search']);

        Route::post('rate/{propertyId}',[PropertyController::class,'rate_property']);

    //============================== Favorites =======================================

        Route::post('addFavorite/{propertyId}',[PropertyFavoriteController::class,'add_property_to_favorites']);

        Route::get('showFavoritesList',[PropertyFavoriteController::class,'show_my_favorites']);

        Route::delete('removeFromFavorites/{propertyId}',[PropertyFavoriteController::class,'remove_from_favorites']);
    });

    //=================================== Reservations ===================================

    Route::post('book/{propertyId}',[ReservationController::class,'booking']);

    Route::put('editBooking/{bookingId}',[ReservationController::class,'edit_booking']);

    Route::post('cancelBooking/{bookingId}',[ReservationController::class,'cancel_booking']);

    Route::get('getTenantBookings',[ReservationController::class,'tenant_bookings']);

    Route::get('showAllBookingsForOneProperty/{propertyId}',[ReservationController::class,'show_all_bookings_for_one_property']);
    
    Route::get('showAllBookingsForOnePropertyWithoutOne/{propertyId}/{withoutThisBooking_id}',[ReservationController::class,'show_all_bookings_without_one']);

    //=================================== Location =======================================

    Route::group(['prefix'=>'location'],function(){

       Route::get('governorates',[LocationController::class,'get_all_governorates']);

       Route::get('cities/{governorateId}',[LocationController::class,'get_all_cities']);
    });

    //=================================== Admin Routes ===================================

    Route::middleware('CheckUser')->group(function(){
        Route::group(['prefix'=>'admin'],function(){

            Route::get('showAllPendingUser',[UserController::class,'pendingUser']);

            Route::post('updateUserStatus/{user_id}',[UserController::class,'updateUserStatus']);
        });
    });

    // =================================== Owner Routes ===================================

    Route::group(['prefix'=>'owner'],function(){

        Route::get('Dashboard',[OwnerDashboardController::class,'booking_requests']);

        Route::put('updateRequestStatus/{booking_id}',[OwnerDashboardController::class,'update_booking_status']);
     });


     // =================================== WhatsApp ===================================
    Route::prefix('chat')->group(function(){

        Route::post('/property/{propertyId}', [ConversationController::class, 'createOrFetch']);

        Route::get('/my', [ConversationController::class, 'myConversations']);

     });
    Route::prefix('messages')->group(function(){

        Route::post('/send', [MessageController::class, 'send']);

        Route::get('', [MessageController::class, 'fetchMessages']);

    });

    // ===================================== Notifications ================================
    Route::get('notify',[NotificationController::class,'getAllNotifications']);
});

// =================================== Public Routes ===================================

Route::post('editRole/{user_id}',[UserController::class,'editRole']);

Route::post('register',[UserController::class,'register']);

Route::post('login',[UserController::class,'login']);

Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');
