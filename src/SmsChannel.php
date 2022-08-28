<?php

namespace MoeenBasra\SendPk;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!$notifiable->routeNotificationFor('sms', $notification)) {
            return;
        }

        $notification->toSms($notifiable)->send();
    }
}
