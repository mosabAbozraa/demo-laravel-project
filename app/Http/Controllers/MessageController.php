<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Http\Resources\MessagesResource;
use App\Models\Booking;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //////////////////////////////// Send Message /////////////////////////////
        public function send(SendMessageRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        $conv = Conversation::find($data['conversation_id']);
        if (!$conv) {
            return response()->json(['message'=>'Conversation not found'], 404);
        }

        //  هاد الشرط يامصعب مشان اتاكد ان المحادثة بين هل ثلاث اطراف بتحديد ولازم يكون موجود بكل توابع الرسائل
        if (!in_array($user->id, [$conv->tenant_id, $conv->owner_id])) {
            return response()->json(['message'=>'Forbidden: you are not participant of this conversation'], 403);
        }

        $message = Message::create([
            'conversation_id' => $conv->id,
            'sender_id' => $user->id,
            'contents' => $data['contents'],
        ]);
        $conv->touch();

        $booking = Booking::where('property_id', $conv->property_id)->where('tenant_id', $conv->tenant_id)->latest()->first();
        if($user->id === $conv->owner_id){
            $receiver_Id = $conv->tenant_id;
        } else {
            $receiver_Id = $conv->owner_id;
        }
        Notification::create([
            'user_id' => $receiver_Id,
            'booking_id' => $booking ? $booking->id : null,
            'title' => 'Chat Message',
            'content' => $message->contents,
            'is_seen' => false,
        ]);


        return response()->json(['message' => $message], 201);
    }
    //////////////////////////////// Fetch Messages /////////////////////////////
     public function fetchMessages(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'conversation_id' => 'required|integer|exists:conversations,id',
        ]);

        $conv = Conversation::find($validated['conversation_id']);

        if (!$conv) {
            return response()->json(['message'=>'Conversation not found'], 404);
        }

        if (!in_array($user->id, [$conv->tenant_id, $conv->owner_id])) {
            return response()->json(['message'=>'Forbidden: you are not participant of this conversation'], 403);
        }


        $messages = $conv->messages()->get();

        return MessagesResource::collection($messages);
    }
}
