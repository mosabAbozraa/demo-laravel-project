<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request){
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);
        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('avatars','public');
            $validated['avatar'] = $path;
        }
        if($request->hasFile('id_photo')){
            $path = $request->file('id_photo')->store('','id_photos');
            $validated['id_photo'] = $path;
        }   
        $user = User::create($validated);
        return response()->json($user,201);
    }

    public function login(Request $request){

    }
}
