<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationsResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //================================= Get All Notifications Method ==================================
    public function getAllNotifications(){
        $user = Auth::user();
        $notifications = Notification::where('user_id',$user->id)->orderBy('created_at','desc')->get();

        return NotificationsResource::collection($notifications);
    }
    //================================= Update Notifications Status Method ==================================
    public function updateNotificationsStatus(){
        $user = Auth::user();
        Notification::where('user_id',$user->id)->update([
            'is_seen' => true
        ]);
    }

    //================================= Count Unseen Notifications Method ==================================
    public function countUnseenNotifications(){
        $user = Auth::user();
        $count = Notification::where('user_id',$user->id)->where('is_seen',false)->count();

        return response()->json(['count' => $count]);
    }
}
