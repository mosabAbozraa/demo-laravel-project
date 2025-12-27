<?php

namespace App\Models;

use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Property extends Model
{
    protected $guarded = ['id'];

    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }

    public function tenants(){
        return $this->belongsToMany(User::class,'bookings','property_id','tenant_id');
    }

    public function images(){
        return $this->hasMany(Media::class);
    }

    public function scopeFilter($query ,array $filters){
        if(isset($filters['governorate_id'])){
            $query->where('governorate_id', $filters['governorate_id']);
        }
        if(isset($filters['city_id'])){
            $query->where('city_id', $filters['city_id']);
        }
        if(isset($filters['min_price'])){
            $query->where('price','>=',$filters['min_price']);
        }
        if(isset($filters['max_price'])){
            $query->where('price','<=',$filters['max_price']);
        }
        if(isset($filters['rooms'])){
            $query->where('rooms',$filters['rooms']);
        }
        if(isset($filters['bath_rooms'])){
            $query->where('bath_rooms',$filters['bath_rooms']);
        }
        return $query;
    }

}
