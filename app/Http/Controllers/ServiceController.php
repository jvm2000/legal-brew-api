<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Cart $cart)
    {
        $services = \App\Models\Service::where('cart_id', $cart->id)
            ->orderBy('created_at', 'desc')
            ->get();

        
        return response()->json($services);
    }

    public function store(Request $request)
    {
        $form = $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'name' => 'required|string',
            'description' => 'required',
            'price' => 'required',
        ]);

        $service = Service::create($form);

        return response()->json($service, 201);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json(null, 204);
    }
}
