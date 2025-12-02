<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = ['id'];
    
    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function tenants(){
        return $this->belongsToMany(User::class,'bookings');
    }
}
