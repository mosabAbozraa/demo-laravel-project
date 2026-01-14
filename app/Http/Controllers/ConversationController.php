<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConversationDetailsResource;
use App\Http\Resources\MyConversationsResource;
use App\Models\Conversation;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    //////////////////////////////// Create Or Fetch Conversation /////////////////////////////
       public function createOrFetch($propertyId)
    {
        $user = Auth::user();

        $property = Property::find($propertyId);
        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        if ($property->owner_id === $user->id) {//ما بعرف بس بحس يلي رح تطلعلو هي رسالة هو شخص بدو دكتور نفسي
            return response()->json(['message' => 'You cannot start a conversation for your own property'], 403);
        }

        $tenantId = $user->id;
        $ownerId = $property->owner_id;

        $conversation = Conversation::where('property_id', $property->id)
            ->where('tenant_id', $tenantId)
            ->where('owner_id', $ownerId)
            ->first();

        if ($conversation) {
            return response()->json(['conversation' => $conversation], 200);
        }

        $conversation = Conversation::create([
            'property_id' => $property->id,
            'tenant_id' => $tenantId,
            'owner_id' => $ownerId,
        ]);

        return response()->json(['conversation' => $conversation], 201);
    }

    ////////////////////////////////////////// My Conversations /////////////////////////////
    // Not Ready To Use Yet, We Will Reveal It Later
    public function myConversations()
    {
        $user = Auth::user();
        $conversations = Conversation::where('tenant_id', $user->id)
            ->orWhere('owner_id', $user->id)
            ->latest('updated_at')
            ->get();

        return MyConversationsResource::collection($conversations);

    }

    ////////////////////////////////////// Conversation Details /////////////////////////////
    public function getConversationDetails(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'conversation_id' => 'required|integer|exists:conversations,id',
        ]);
        $conversation_id = $validated['conversation_id'];

        $conv = Conversation::where('id', $conversation_id)->first();

        if (!$conv) {
            return response()->json(['message'=>'Conversation not found'], 404);
        }

        if (!in_array($user->id, [$conv->tenant_id, $conv->owner_id])) {
            return response()->json(['message'=>'Forbidden: you are not participant of this conversation'], 403);
        }
        return new ConversationDetailsResource($conv);
        
    }
}
