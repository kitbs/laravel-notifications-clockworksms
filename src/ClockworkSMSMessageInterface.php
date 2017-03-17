<?php

namespace NotificationChannels\ClockworkSMS;

interface ClockworkSMSMessageInterface
{
    /**
     * The message object.
     *
     * @var \MJErwin\Clockwork\Message
     */
    protected $message;

    /**
     * Get the message object.
     *
     * @return $message
     */
    public function getMessage();

    /**
     * Set the message object.
     *
     * @param  $message
     * @return void
     */
    public function setMessage($message);

}
