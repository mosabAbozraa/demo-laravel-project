<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectedUsers extends Model
{
    protected $table = 'rejected_users';
    protected $guarded = ['id'];
}
