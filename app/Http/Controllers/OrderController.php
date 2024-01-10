<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Exception;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function processOrderPayment(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
              'user_id' => 'required|user,id',
              'price' => 'required|numeric',
              'payment_status' => 'required'
            ]);

            // Find the order by id
            $order = Order::findOrFail($id);

            // Check if the order has already been paid
            if ($order->payment_status === 'completed') {
                $response = [
                    'status' => 400,
                    'message' => 'Order has already been paid',
                ];
            } else {
                // Ensure that the 'price' attribute exists in the order model
                if (!$order->price) {
                    $response = [
                        'status' => 400,
                        'message' => 'Invalid order: missing or invalid price',
                    ];
                } else {
                    $provider = new PayPalClient();
                    
                    // Set API credentials
                    $provider->setApiCredentials(config('paypal.credentials'));

                    // Set currency
                    $provider->setCurrency(config('paypal.currency'));

                    // Get PayPal access token
                    $paypalToken = $provider->getAccessToken();

                    // Create an order
                    $response = $provider->createOrder([
                        'intent' => 'CAPTURE',
                        'purchase_units' => [
                            [
                                'amount' => [
                                    'currency_code' => config('paypal.currency'),
                                    'value' => $order->price,
                                ],
                            ],
                        ],
                    ], $paypalToken); 

                    // Check if the request was successful
                    if ($response['paypal_link']) {
                        return redirect($response['paypal_link']);
                    } else {
                        // Handling error
                        $response = [
                            'status' => 500,
                            'message' => 'Error initiating PayPal payment',
                        ];
                    }

                    // Update the order's payment status after successful payment
                    $order->update(['payment_status' => 'completed']);

                    $response = [
                        'status' => 200,
                        'order' => $order,
                        'message' => 'Order payment processed successfully',
                    ];
                }
            }
        } catch (Exception $error) {
            // Handling any exception
            $response = [
                'status' => 500,
                'message' => $error->getMessage(),
            ];
        }

        return response()->json($response);
    }
}
