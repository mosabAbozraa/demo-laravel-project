<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class UserController extends Controller
{
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

    public function login(LoginRequest $request)
{
    if (!Auth::attempt($request->only('phone', 'password'))) {
        return response()->json([
            'message' => 'Wrong phone number or password'
        ], 401);
    }

    $user = User::where('phone', $request->phone)->first();

    if ($user->status === 'pending') {
        return response()->json([
            'message' => 'Your account is waiting for admin approval'
        ], 403);
    }

    if ($user->status === 'rejected') {
        return response()->json([
            'message' => 'Your account request has been rejected'
        ], 403);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'access_token' => $token,
        'user' => $user
    ], 200);
}

    public function logout(){
        // auth()->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'logout successful'],200);
}


    public function pendingUser(){
        $users =User::where('approval_status','pending')->get();
        return response()->json($users,200);
    }

    public function updateUserStatus(Request $request,$id){
        $request->validate([
            'approval_status'=>'required|in:approved,rejected'
        ]);

        $user = User::find($id);
        $user->approval_status = $request->approval_status;
        $user->save();

        return response()->json(['message'=>'User status updated successfully'],200);
    }
}
