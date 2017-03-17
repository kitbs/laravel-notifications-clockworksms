<?php

namespace NotificationChannels\ClockworkSMS\Exceptions;

use NotificationChannels\ClockworkSms\ClockworkSMSMessageInterface;
use NotificationChannels\ClockworkSms\ClockworkSMSResponseInterface;

use Exception;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError(ClockworkSMSResponseInterface $response)
    {
        $code = $response->getCode();
        $error = $response->getMessage();

        return new static("Error {$code}: $error");
    }

    public static function genericException(Exception $exception)
    {
        return new static($exception->getMessage(), $exception->getCode(), $exception);
    }

    public static function invalidMessageObject($message)
    {
        if ($message instanceof ClockworkSMSMessageInterface) {
            if (! $message->to) {
                $error = 'Notification was not sent. No number set in the message.';
            } elseif (! $message->content) {
                $error = 'Notification was not sent. No content set in the message.';
            } else {
                $error = 'Notification was not sent. Message is invalid.';
            }
        } else {
            $className = get_class($message) ?: 'Unknown';

            $error = "Notification was not sent. Message object class `{$className}` is invalid. It must be `".ClockworkSmsMessage::class.'`.';
        }

        return new static($error);
    }
}
