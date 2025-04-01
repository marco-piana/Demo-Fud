<?php

namespace Modules\Paypal\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class App 
{
    private $order;
    private $vendor;

    public function __construct($order, $vendor) {
        $this->order = $order;
        $this->vendor = $vendor;
    }

    public function execute(){
        // System setup 
        $client_id = config('paypal.client_id');
        $secret = config('paypal.secret');
        $mode = config('paypal.mode');

        // Setup based on vendor
        if (config('paypal.useVendor')) {
            $client_id = $this->vendor->getConfig('paypal_client_id', '');
            $secret = $this->vendor->getConfig('paypal_secret', '');
            $mode = $this->vendor->getConfig('paypal_mode', 'sandbox');
        }

        \App\Services\ConfChanger::switchCurrency($this->order->restorant);

        $apiUrl = $mode === 'sandbox' ? 'https://api-m.sandbox.paypal.com' : 'https://api.paypal.com';
        $accessToken = $this->getAccessToken($apiUrl, $client_id, $secret);

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ];

        $itemsArr = [];
        foreach ($this->order->items as $key => $item) {
            $itemObj = [
                'name' => $item->name . ' ' . $item->variant_name,
                'currency' => strtoupper(config('settings.cashier_currency')),
                'quantity' => intval($item->pivot->qty),
                'sku' => strval($item->id),
                'price' => $item->pivot->variant_price,
            ];

            $itemsArr[] = $itemObj;
        }

        // Add delivery
        if ($this->order->delivery_price > 0) {
            $itemObj = [
                'name' => __('Delivery'),
                'currency' => strtoupper(config('settings.cashier_currency')),
                'quantity' => 1,
                'sku' => 0,
                'price' => $this->order->delivery_price,
            ];
            $itemsArr[] = $itemObj;
        }

        

        //Add tip
        if ($this->order->tip > 0) {
            $itemObj = [
                'name' => __('Tip'),
                'currency' => strtoupper(config('settings.cashier_currency')),
                'quantity' => 1,
                'sku' => 0,
                'price' => $this->order->tip,
            ];
            $itemsArr[] = $itemObj;
        }

        $amount = [
            'currency' => strtoupper(config('settings.cashier_currency')),
            'total' => number_format($this->order->order_price_with_discount + $this->order->delivery_price, 2, '.', ''),
        ];

        // Add discount
        if ($this->order->discount > 0) {
            $amount['details'] = [
                'shipping_discount' => number_format(-1 * $this->order->discount, 2, '.', '')
            ];  
        }

        $transaction = [
            'amount' => $amount,
            'item_list' => [
                'items' => $itemsArr,
            ],
            'description' => __('Payment for order on ') . config('settings.app_name'),
            'invoice_number' => $this->order->id,
        ];

        $redirectUrls = [
            'return_url' => route('paypal.execute') . '?success=true&vendor_id=' . $this->vendor->id,
            'cancel_url' => route('paypal.cancel'),
        ];

        $payment = [
            'intent' => 'sale',
            'payer' => [
                'payment_method' => 'paypal',
            ],
            'redirect_urls' => $redirectUrls,
            'transactions' => [$transaction],
        ];

        try {
            $response = Http::withHeaders($headers)->post($apiUrl . '/v1/payments/payment', $payment);

            if ($response->successful()) {
                $approvalLink = collect($response->json()['links'])->firstWhere('rel', 'approval_url');

                if ($approvalLink) {
                    // Set payment link in order
                    $this->order->payment_link = $approvalLink['href'];
                    $this->order->update();

                    // All ok
                    return Validator::make([], []);
                } else {
                    return Validator::make(['paypal_payment_approval_missing' => null], ['paypal_payment_approval_missing' => 'required']);
                }
            } else {
                return Validator::make(['paypal_payment_error_action' => null], ['paypal_payment_error_action' => 'required']);
            }
        } catch (\Exception $ex) {
            // On Fail delete order
            dd($ex);
            return Validator::make(['paypal_payment_error_action' => null], ['paypal_payment_error_action' => 'required']);
        }
    }

    private function getAccessToken($apiUrl, $client_id, $secret) {
        $response = Http::withBasicAuth($client_id, $secret)
            ->asForm()
            ->post($apiUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        } else {
            throw new \Exception('Failed to get access token from PayPal API');
        }
    }
}