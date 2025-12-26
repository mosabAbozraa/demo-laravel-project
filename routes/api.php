<?php

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){
    Route::group(['prefix'=>'properties'],function(){
        Route::post('add',[PropertyController::class,'add_property_to_owner']);  
        Route::get('showAll',[PropertyController::class,'show_all_properties']);    
        Route::get('showOne/{propertyId}',[PropertyController::class,'getProperty']);
        Route::get('filterSearch',[PropertyController::class,'search']);
        Route::post('rate/{propertyId}',[PropertyController::class,'rate_property']);
        //=================================== Reservations ===================================
        Route::post('book/{propertyId}',[ReservationController::class,'booking']);
    });
    
    //=================================== Admin Routes ===================================
    Route::middleware('CheckUser')->group(['prefix'=>'admin'],function(){
        Route::get('showAllPendingUser',[UserController::class,'pendingUser']);
        Route::post('updateUserStatus/{user_id}',[UserController::class,'updateUserStatus']);
        Route::post('editRole/{user_id}',[UserController::class,'editRole']);
    });
});


