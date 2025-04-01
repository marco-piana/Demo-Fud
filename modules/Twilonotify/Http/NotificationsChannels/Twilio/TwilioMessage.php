<?php

namespace Modules\Twilonotify\Http\NotificationsChannels\Twilio;

use Illuminate\Notifications\Notification;


class TwilioMessage
{
    public $body;

    public function __construct( $body = null)
    {
        $this->body = $body;
    }

    public function body($body)
    {
        $this->body = $body;
        return $this;
    }
}