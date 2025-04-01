<?php

namespace Modules\Twilonotify\Http\NotificationsChannels\Twilio;
use Illuminate\Notifications\Notification;


class TwilioChannel
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
            $message = $notification->toTwilio($notifiable);

            // Send notification to the $notifiable instance...
            //$notifiable instanceof Customer;
            $to = $notifiable->phone;
            $message = $message->body;
            
            //Send SMS via Twilio
            $sid    = config('twilonotify.twilio_account_sid');
            $token  = config('twilonotify.twilio_auth_token');
            $from   = config('twilonotify.twilio_phone_number');

            //Make an API call, don't use php client
            $url = "https://api.twilio.com/2010-04-01/Accounts/".$sid."/Messages.json";
            $data = array (
                'From' => $from,
                'To' => $to,
                'Body' => $message,
            );
            $post = http_build_query($data);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $sid.":".$token);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
        
    }
}