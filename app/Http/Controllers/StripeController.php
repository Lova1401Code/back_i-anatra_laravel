<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function getSession(){
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $checkout = $stripe->checkout->sessions->create([
            'success_url' => 'https://example.com/success',
            'line_items' => [
              [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => 500,
                    'product_data' => [
                        'name' => "cool stripe checkout"
                    ],
                ],
                'quantity' => 1,
              ],
            ],
            'mode' => 'payment',
          ]);
          return response()->json($checkout);
    }
}
