<?php

namespace Modules\Tablereservations\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Twilonotify\Http\NotificationsChannels\Twilio\TwilioChannel;
use Modules\Twilonotify\Http\NotificationsChannels\Twilio\TwilioMessage;
use Modules\Tablereservations\Models\Reservation;
use Modules\Whatsappnotify\Http\NotificationsChannels\Whatsapp\WhatsappChannel;
use Modules\Whatsappnotify\Http\NotificationsChannels\Whatsapp\WhatsappMessage;

class ReservationConfirmed extends Notification
{
    use Queueable;
    public $reservation;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $notifyVia = [];
        $nofificationChannel = config('tablereservations.channel',"none");
        if($nofificationChannel == "twilio"){
            $notifyVia[] = TwilioChannel::class;
        }
        if($nofificationChannel == "whatsapp"){
            $notifyVia[] = WhatsappChannel::class;
        }
        if($nofificationChannel == "twilioandwhatsapp"){
            $notifyVia[] = TwilioChannel::class;
            $notifyVia[] = WhatsappChannel::class;
        }
        
        //Log it
        Log::info($notifyVia);
        return $notifyVia;
    }

    //Twilio
    public function toTwilio($notifiable)
    {
        $message = $this->reservation->company->name . ".\n". $this->reservation->relative_time . ".\n";
        $message .= $this->reservation->customer->name . " ," . __("Your reservation has been confirmed."). "\n";
        $message .= " " . __("Reservation code") . ": " . $this->reservation->reservation_code;

        return (new TwilioMessage($message));
    }

    //Whatsapp
    public function toWhatsapp($notifiable)
    {
       
        $campaing_id = config('tablereservations.campaing_id_confirm',"");
        $data=[
            'campaing_id'=>$campaing_id,
            'reservation'=>$this->reservation->toArray()
            
        ];
       
        return (new WhatsappMessage($data));
       
    }
}
