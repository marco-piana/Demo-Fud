<?php

namespace Modules\Whatsappnotify\Http\NotificationsChannels\Whatsapp;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {

        try {
            $whatsMessage = $notification->toWhatsapp($notifiable);
            

                // Send notification to the $notifiable instance...
                //$notifiable instanceof Customer;
            
                $to = $notifiable->phone;
                $data = $whatsMessage->data;
                $campaing_id=$whatsMessage->data['campaing_id'];
                
                //Send Message to Whatsapp
                $whats_box_url    = config('whatsappnotify.whats_box_url');
                $whats_box_api_token  = config('whatsappnotify.whats_box_api_token');


        
                //Make an API call, don't use php client
                $response = Http::post( $whats_box_url."/api/wpbox/sendcampaigns", [
                    'token' => $whats_box_api_token,
                    'campaing_id' =>$campaing_id,
                    'phone' => $to,
                    'data' => $data
                ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return true;
        
    }
}