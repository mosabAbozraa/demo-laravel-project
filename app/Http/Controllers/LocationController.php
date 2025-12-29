<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Http\Resources\GovernorateResource;
use App\Models\Governorate;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function get_all_governorates(){
        $governorates = Governorate::all();
        return GovernorateResource::collection($governorates);
    }

    public function get_all_cities($governorateId){
        $governorate = Governorate::find($governorateId);
        $cities = $governorate->cities;
        return CityResource::collection($cities);
    }

}
