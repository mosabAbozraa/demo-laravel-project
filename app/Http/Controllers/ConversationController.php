<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    //
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


    // Not Ready To Use Yet, We Will Reveal It Later
    //     public function myConversations()
    // {
    //     $user = Auth::user();

    //     $conversations = Conversation::where('tenant_id', $user->id)
    //         ->orWhere('owner_id', $user->id)
    //         ->with(['property' => function($q){
    //             $q->select('id','price_per_night','owner_id');
    //         }])
    //         ->with(['messages' => function($q){
    //             $q->latest()->limit(1);
    //         }])
    //         ->latest('updated_at')
    //         ->get()
    //         ->map(function($conv){
    //             $lastMsg = $conv->messages->first();
    //             return [
    //                 'id' => $conv->id,
    //                 'property' => $conv->property,
    //                 'tenant_id' => $conv->tenant_id,
    //                 'owner_id' => $conv->owner_id,
    //                 'last_message' => $lastMsg ? [
    //                     'contents' => $lastMsg->contents,
    //                     'sender_id' => $lastMsg->sender_id,
    //                     'created_at' => $lastMsg->created_at,
    //                 ] : null,
    //                 'updated_at' => $conv->updated_at,
    //             ];
    //         });

    //     return response()->json(['conversations' => $conversations], 200);
    // }
}
