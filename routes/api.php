<?php

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);

Route::post('property',[PropertyController::class,'create_property_for_owner']);

Route::post('rent/{propertyId}',[PropertyController::class,'booking']);
