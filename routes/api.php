<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ServiceController;
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

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken,
        'token_type' => 'Bearer',
        'user' => $user
    ]);
});
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $user = $request->user();

    if ($user && $user->currentAccessToken()) {
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    return response()->json(['message' => 'Not authenticated or token missing'], 401);
});
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Post 
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);

// Comments 
Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store']);
Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

// Reactions 
Route::post('/reactions', [ReactionController::class, 'store']);
Route::delete('/reactions/{reaction}', [ReactionController::class, 'destroy']);

// Carts 
Route::get('/cart/{user}', [CartController::class, 'index']);
Route::post('/carts', [CartController::class, 'store']);
Route::delete('/carts/{cart}', [CartController::class, 'destroy']);

// Services 
Route::get  ('/cart/{cart}/services', [ServiceController::class, 'index']);
Route::post('/services', [ServiceController::class, 'store']);
Route::delete('/services/{reaction}', [ServiceController::class, 'destroy']);

