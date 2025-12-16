<?php

use App\Http\Controllers\PropertyController;
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
    Route::post('addProperty',[PropertyController::class,'add_property_to_owner']);
    Route::post('rent/{propertyId}',[PropertyController::class,'booking']);
    Route::get('showAllProperties',[PropertyController::class,'show_all_properties']);
    //=================================== Admin Routes ===================================
    Route::get('admin/showAllPendingUser',[UserController::class,'pendingUser'])->middleware('CheckUser');
    Route::post('admin/updateUserStatus/{user_id}',[UserController::class,'updateUserStatus'])->middleware('CheckUser');

});


