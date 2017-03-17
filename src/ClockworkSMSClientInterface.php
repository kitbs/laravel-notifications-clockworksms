<?php

namespace NotificationChannels\ClockworkSMS;

interface ClockworkSMSClientInterface
{
    public function __construct($key, $truncate, $invalidCharAction, $from = null);

    public function send(ClockworkSMSMessage $message);

    public function setApiKey($key);

    public function getApiKey();

    public function setTruncate($truncate);

    public function getTruncate();

    public function setInvalidCharAction($action);

    public function getInvalidCharAction();

    public function getBalance();

}
