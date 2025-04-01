<?php

namespace Modules\Paypal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use GuzzleHttp\Client;
use App\Order;
use App\Restorant;
use Exception;

class Main extends Controller
{

    //callback after payment
    public function executePayment(Request $request)
    {
        $vendor = Restorant::findOrFail($_GET['vendor_id']);
    
        //System setup 
        $client_id=config('paypal.client_id');
        $secret=config('paypal.secret');
        $mode=config('paypal.mode');
    
        //Setup based on vendor
        if(config('paypal.useVendor')){
            $client_id=$vendor->getConfig('paypal_client_id','');
            $secret=$vendor->getConfig('paypal_secret','');
            $mode=$vendor->getConfig('paypal_mode','sandbox');
        }
    
        $base_url = $mode == 'sandbox' ? 'https://api-m.sandbox.paypal.com' : 'https://api.paypal.com';
    
        try {
            $dataArray = $request->all();
    
            /* If the request success is true process with payment execution*/
            if (isset($_GET['success']) && $_GET['success'] == 'true' && $dataArray['success'] == 'true') {
    
                /* If the payer ID or token aren't set, there was a corrupt response */
                if (empty($dataArray['PayerID']) || empty($dataArray['token'])) {
                    return redirect()->route('cart.checkout')->withMesswithErrorage('The payment attempt failed')->withInput();
                }
    
                $paymentId = $_GET['paymentId'];
    
                // Get access token
                $client = new Client();
    
                $response = $client->request('POST', $base_url . '/v1/oauth2/token', [
                    'auth' => [$client_id, $secret],
                    'form_params' => [
                        'grant_type' => 'client_credentials'
                    ]
                ]);
    
                $json = json_decode($response->getBody());
                $access_token = $json->access_token;
    
                // Execute payment
                $response = $client->request('POST', $base_url . '/v1/payments/payment/' . $paymentId . '/execute/', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $access_token
                    ],
                    'json' => [
                        'payer_id' => $_GET['PayerID']
                    ]
                ]);
    
                $json = json_decode($response->getBody());
    
                if ($json->state == 'approved') {
                    $order_id = intval($json->transactions[0]->invoice_number);
    
                    $order = Order::findOrFail($order_id);
    
                    $order->payment_status = 'paid';
    
                    $order->update();
    
                    return redirect()->route('order.success', ['order' => $order]);
                }
            }
        } catch (Exception $ex) {
            
            return redirect()->route('cart.checkout')->withMesswithErrorage('The payment attempt failed because additional action is required before it can be completed.')->withInput();
        }
    }

    //Canceled payment
    public function cancelPayment(Request $request){
        return redirect()->route('cart.checkout')->withMesswithErrorage('The payment attempt was canceled')->withInput();
    }
    
}
