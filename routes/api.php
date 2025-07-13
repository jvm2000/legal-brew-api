<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;

// Authentication 
Route::post('/login', function (Request $request) {
    $request->validate([
        'login' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $login = $request->input('login');

    // Check if login is an email
    $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $user = User::where($fieldType, $login)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json(['message' => 'Logged in', 'user' => $user]);
});
Route::post('/logout', function (Request $request) {
    auth()->guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json(['message' => 'Logged out']);
});
Route::post('/register', [AuthController::class, 'register']);

// Post 
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);

// Comments 
Route::post('/comments', [CommentController::class, 'store']);
Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

// Reactions 
Route::post('/reactions', [ReactionController::class, 'store']);
Route::delete('/reactions/{reaction}', [ReactionController::class, 'destroy']);

