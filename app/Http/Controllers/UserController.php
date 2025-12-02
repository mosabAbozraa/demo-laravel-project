<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function regiter(Request $request){
        $request->validate([
            'phone' => 'unique:users,phone'
        ]);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth
        ]);
        return response()->json($user,201);
    }

    public function login(Request $request){

    }

    public function loginNormalUser(Request $request){

    }

    public function loginAdminUser(Request $request){

    }
}
