<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Http\Resources\MessagesResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
        public function send(SendMessageRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        $conv = Conversation::find($data['conversation_id']);
        if (!$conv) {
            return response()->json(['message'=>'Conversation not found'], 404);
        }

        if (!in_array($user->id, [$conv->tenant_id, $conv->owner_id])) {
            return response()->json(['message'=>'Forbidden: you are not participant of this conversation'], 403);
        }

        $message = Message::create([
            'conversation_id' => $conv->id,
            'sender_id' => $user->id,
            'contents' => $data['contents'],
        ]);

        $conv->touch();

        return response()->json(['message' => $message], 201);
    }

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
