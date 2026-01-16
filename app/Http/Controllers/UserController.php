<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\ProfileResource;
use App\Models\RejectedUsers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // =============================== Register Method ==================================
    public function register(RegisterRequest $request){
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);
        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('avatars','public'); // ('folder name' , 'disk' )
            $validated['avatar'] = $path;
        }
        if($request->hasFile('id_photo')){
            $path = $request->file('id_photo')->store('id_photos','private');
            $validated['id_photo'] = $path;
        }
        $user = User::create($validated);
        return response()->json($user,201);
    }

    // =============================== Login Method ==================================
    public function login(LoginRequest $request)
    {
        $isRejected = RejectedUsers::where('phone',$request->phone)->first();
        if ($isRejected) {
            return response()->json([
                'message' => 'Your account request has been rejected'
            ], 403);
        }
        if (!Auth::attempt($request->only('phone', 'password'))) {
            return response()->json([
            'message' => 'Wrong phone number or password'
            ], 401);
        }

    $user = User::where('phone', $request->phone)->first();
    if ($user->approval_status === 'pending') {
        return response()->json([
            'message' => 'Pending.... Your account is waiting for admin approval'
        ], 403);
    }



    // $token = $user->createToken('auth_token')->plainTextToken;

    return new LoginResource($user);
    }

    // =============================== Logout Method ==================================
    public function logout(){
            // auth()->user()->currentAccessToken()->delete();
            return response()->json(['message'=>'logout successful'],200);
    }

    // =============================== Get User Profile ==================================
    public function get_user_profile(){
        $user = Auth::user();
        return new ProfileResource($user);
    }

}
