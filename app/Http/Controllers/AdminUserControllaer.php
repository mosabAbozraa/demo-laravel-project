<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\RejectedUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserControllaer extends Controller
{

    // =============================== Pending Users Method ==================================
    public function pendingUser(){
        $users =User::all();
        $rejected_users = RejectedUsers::all();
        return view('admin.pending-users', compact('users','rejected_users'));
    }

    // =============================== Approve User Method ==================================
    public function approveUser($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'],404);
        }
        $user->approval_status = 'approved';
        $user->save();

        Notification::create([
            'user_id'   => $user->id,
            'title'     => 'Admin response',
            'content'   => 'Congrats :) Welcome to LuxeStay, Admin approved your request',
            'is_seen'   => false 
        ]);
        return redirect()->back()->with('success', 'User approved successfully');
    }

    // =============================== Reject User Method ==================================
    public function rejectUser($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'],404);
        }

        RejectedUsers::create(
            $user->only(['first_name', 'last_name', 'phone'])
            +['rejected_at' => now(), 'reason' => $reason ?? null]
        );

        $user->delete();
        return redirect()->back()->with('success', 'User rejected successfully');
    }

    // =============================== Delete User Method ==================================
    public function deleteUser($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'],404);
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    // =============================== Delete Reject User =========================================
    public function deleteRejectUser($id){
        $user = RejectedUsers::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'],404);
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }



    // =============================== Post man ===================================================
    // =============================== Update User Status Method ==================================
    public function updateUserStatus(Request $request,$id){
        $request->validate([
            'approval_status'=>'required|in:approved,rejected'
        ]);

        $user = User::find($id);
        $user->approval_status = $request->approval_status;
        $user->save();

        return response()->json(['message'=>'User status updated successfully'],200);
    }

     // =============================== Edit Role Method ==================================
    public function editRole(Request $request, $id){
        $request->validate([
            'role'=>'required|in:tenant,owner,admin'
        ]);

        $user = User::find($id);
        $user->role = $request->role;
        $user->save();

        return response()->json(['message'=>'User role updated successfully'],200);
    }

    // =============================== Admin Login Methods ==================================
     public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone'    => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'login' => 'Invalid credentials'
            ]);
        }

        $user = Auth::user();

        if ($user->role !== 'admin') {
            Auth::logout();
            return back()->withErrors([
                'login' => 'Access denied. Admins only.'
            ]);
        }

        return redirect()->route('admin.users.pending');
    }
}
