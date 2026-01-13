<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationsResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getAllNotifications(){
        $user = Auth::user();
        $notifications = Notification::where('user_id',$user->id)->orderBy('created_at','desc')->get();

        return NotificationsResource::collection($notifications);
    }

    public function updateNotificationsStatus(){
        $user = Auth::user();
        Notification::where('user_id',$user->id)->update([
            'is_seen' => true
        ]);
    }
}

