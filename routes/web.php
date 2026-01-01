<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserControllaer;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/users/pending', [AdminUserControllaer::class, 'pendingUser'])
        ->name('admin.users.pending');

    Route::post('/users/{id}/approve', [AdminUserControllaer::class, 'approveUser'])
        ->name('admin.users.approve');

    Route::post('/users/{id}/reject', [AdminUserControllaer::class, 'rejectUser'])
        ->name('admin.users.reject');

     Route::delete('/users/{id}', [AdminUserControllaer::class, 'deleteUser'])->name('admin.users.delete');
        
Route::get('/login', [AdminUserControllaer::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AdminUserControllaer::class, 'login']);

Route::get('/dashboard', function () {
    return view('admin.users.pending');
})->middleware(['auth', 'admin'])->name('admin.users.approve');

});



