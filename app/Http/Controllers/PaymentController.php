<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = Payment::create([
            'method' => 'card',
            'amount' => $request->amount * 100, // amount in cents
            'currency' => 'usd',
            'services' => $request->services,
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
}
