<?php

namespace  Modules\Cards\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoyaltyPointsRemoved extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($client,$card,$award,$coupon,$vendor)
    {
        $this->client = $client;
        $this->card = $card;
        $this->award = $award;
        $this->coupon = $coupon;
        $this->vendor = $vendor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        config([
            'app' =>  [
                'name' => $this->vendor->name,
                'url_set_to_page' => $this->vendor->name,
            ]]
        );
        return (new MailMessage)
                    ->greeting(__('notifications_hello', ['username' => $this->client->name]))
                    ->line(__('notifications_new_coupon', ['vendor_name' => $this->vendor->name]))
                    ->line(__('notifications_new_coupon_details', ['coupon_code' => $this->coupon->code]))
                    ->line(__('notifications_new_coupon_info', ['coupon_title' =>$this->coupon->name]))
                    ->subject(__('notifications_new_coupon', ['vendor_name' => $this->vendor->name]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
