<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    public $guarded = ['id'];

    public function tenant(){
        return $this->belongsTo(User::class,'tenant_id');
    }

    public function property(){
        return $this->belongsTo(Property::class,'property_id');
    }
}
