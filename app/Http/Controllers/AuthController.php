<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $form = $request->validate([
            'username' => 'required|string',
            'full_name' => 'string|required',
            'email' => 'string|unique:users,email|email|required',
            'password' => 'required|string',
            'birthdate' => 'required|string',
            'contact_no' => 'required|string',
            'role' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('users', 'public');
                $imagePaths[] = $path;
            }
        }

        $form['images'] = $imagePaths;

        $user = User::create($form);

        return response()->json($user, 201);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $form = $request->validate([
            'username' => 'sometimes|string|max:255',
            'full_name' => 'sometimes|string|max:255',
            'contact_no' => 'sometimes|string|max:255',
            'birthdate' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        foreach ($form as $key => $value) {
            if ($key !== 'images') {
                $user->$key = $value;
            }
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];

            foreach ($request->file('images') as $image) {
                $path = $image->store('users', 'public');
                $imagePaths[] = $path;
            }

            $user->images = $imagePaths;
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        // Revoke the token used for the current request
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
