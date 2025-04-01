<?php

return [
    'name' => 'Tablereservations',
    'channel' => env('NOTIFICATIONS_CHANNEL_TABLERESERVATIONS', 'none'),
    'send_reject_notification' => env('NOTIFY_RESERVATION_REJECTED', false),
    'send_receive_notification' => env('NOTIFY_RESERVATION_RECEIVED', true),
    'campaing_id_confirm'=>env('CAMPAING_ID_CONFIRM',""),
    'campaing_id_reject'=>env('CAMPAING_ID_REJECT',""),
];
