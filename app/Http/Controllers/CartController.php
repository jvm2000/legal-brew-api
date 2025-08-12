<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(User $user)
    {
        $carts = \App\Models\Cart::with('user')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($carts);
    }

    public function store(Request $request)
    {
        $form = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $cart = Cart::create($form);

        return response()->json($cart, 201);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        $deleted = Cart::where('user_id', $user->id)->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'Cart items deleted successfully.'
            ], 200);
        }

        return response()->json([
            'message' => 'No cart items found to delete.'
        ], 404);
    }
}
