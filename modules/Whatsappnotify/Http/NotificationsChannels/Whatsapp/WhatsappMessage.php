<?php

namespace Modules\Whatsappnotify\Http\NotificationsChannels\Whatsapp;

use Illuminate\Notifications\Notification;


class WhatsappMessage
{
    public $data;


    public function __construct( $data = null)
    {
        $this->data = $data;
    }
}