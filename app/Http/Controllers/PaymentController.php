<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = Payment::create([
            'method' => 'card',
            'amount' => $request->amount * 100, // amount in cents
            'currency' => 'usd',
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function gcash(Request $request)
    {
        $response = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
            ->post('https://api.paymongo.com/v1/sources', [
                'data' => [
                    'attributes' => [
                        'amount' => $request->amount * 100,
                        'redirect' => [
                            'success' => url('/payment/success'),
                            'failed' => url('/payment/failed'),
                        ],
                        'type' => 'gcash',
                        'currency' => 'PHP',
                    ]
                ]
            ]);

        return $response->json(); // returns the GCash payment URL and source ID
    }
}
