<?php

namespace NotificationChannels\ClockworkSMS;

class ClockworkSMSMessage
{
    protected $content;

    public function content($content)
    {
        $this->content = $content;
    }
}
