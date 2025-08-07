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
        // Validate input
        $data = $request->validate([
            'amount' => 'required|integer|min:1',
            'description' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Build the JSON payload
        $payload = [
            'data' => [
                'attributes' => [
                    'amount' => $data['amount'] * 100,
                    'description' => $data['description'],
                    'remarks' => $data['remarks'] ?? '',
                ],
            ],
        ];

        $response = Http::withOptions(['verify' => false])
            ->withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
            ->withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ])
            ->post('https://api.paymongo.com/v1/links', $payload);

        // Return response or error
        if ($response->successful()) {
            $checkoutUrl = $response->json()['data']['attributes']['checkout_url'];
            return response()->json(['checkout_url' => $checkoutUrl]);
        }

        return response()->json([
            'message' => 'Error creating payment link',
            'details' => $response->json(),
        ], $response->status());
    }
}
