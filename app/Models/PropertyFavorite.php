<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyFavorite extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'tenant_id');
    }

    public function favorites(){
        return $this->belongsTo(Property::class,'property_id');
    }
}
