<?php

namespace NotificationChannels\ClockworkSMS;

use NotificationChannels\ClockworkSMS\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;
use NotificationChannels\ClockworkSMS\ClockworkSMSClient;

use MJErwin\Clockwork\Exception\ClockworkResponseException;
use Illuminate\Notifications\Events\NotificationFailed;

class ClockworkSMSChannel
{
    protected $client;

    public function __construct(ClockworkSMSClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\ClockworkSMS\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('clockwork_sms')) {
            if (! $to = $notifiable->phone_number) {
                return;
            }
        }

        $message = $notification->toClockworkSms($notifiable);

        if (is_string($message)) {
            $message = new ClockworkSMSMessage($message);
        }

        if (! $message instanceof ClockworkSMSMessage) {
            throw CouldNotSendNotification::invalidMessageObject($message);
        }

        if (! $message->isValid()) {
            throw CouldNotSendNotification::invalidMessageObject($message);
        }

        try {
            $response = $this->client->send($message);
        } catch (ClockworkResponseException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
