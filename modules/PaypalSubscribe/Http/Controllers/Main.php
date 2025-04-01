<?php

namespace Modules\PaypalSubscribe\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class Main extends Controller
{
    // Subscribe
    public function subscribe(Request $request)
    {
        // Assign user to plan
        auth()->user()->plan_id = $request->planID;
        auth()->user()->paypal_subscription_id = $request->subscriptionID;
        auth()->user()->update();

        return response()->json([
            'status' => true,
            'success_url' => redirect()->intended('/plan')->getTargetUrl(),
        ]);
    }

    public function updateCancelSubscription(Request $request)
    {
        // Get PayPal API settings
        $clientId = config('paypal-subscribe.client_id');
        $clientSecret = config('paypal-subscribe.secret');
        $mode = config('paypal-subscribe.mode') === 'sandbox' ? 'sandbox.' : '';
        $baseUrl = 'https://api.' . $mode . 'paypal.com';

        // Obtain an access token
        $authResponse = Http::withBasicAuth($clientId, $clientSecret)
                            ->asForm()
                            ->post($baseUrl . '/v1/oauth2/token', ['grant_type' => 'client_credentials']);
        $accessToken = $authResponse->json()['access_token'];

        // Setup the HTTP request headers and body
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post(auth()->user()->cancel_url, [
            'reason' => 'Not satisfied with the service'
        ]);

        // Error handling or redirection after attempt to cancel the subscription
        if ($response->failed()) {
            return response()->json(['error' => 'Request failed with status code ' . $response->status()], $response->status());
        }

        return Redirect::to('/plan');
    }
}
