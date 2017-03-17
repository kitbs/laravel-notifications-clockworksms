<?php

namespace NotificationChannels\ClockworkSMS;

use MJErwin\Clockwork\ClockworkClient;

class ClockworkSMSClient
{
    protected $client;

    protected $from;

    protected $invalidCharActions = [
        'error'   => ClockworkClient::INVALID_CHAR_ACTION_RETURN_ERROR,
        'remove'  => ClockworkClient::INVALID_CHAR_ACTION_REMOVE_CHARS,
        'replace' => ClockworkClient::INVALID_CHAR_ACTION_REPLACE_CHARS,
    ];

    protected $truncateActions = [
        'error'    => 0,
        'truncate' => 1,
    ];

    public function __construct($key, $truncate, $invalidCharAction, $from = null)
    {
        $this->client = new ClockworkClient($key);
        $this->setTruncate($truncate);
        $this->setInvalidCharAction($invalidCharAction);
        $this->setFrom($from);
    }

    public function send(ClockworkSMSMessage $message)
    {
        //
    }

    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setApiKey($key)
    {
        $this->client->setApiKey($key);

        return $this;
    }

    public function getApiKey()
    {
        return $this->client->getApiKey();
    }

    public function setTruncate($truncate)
    {
        $truncate = array_get($this->truncateActions, $truncate);

        $this->client->setTruncateEnabled($truncate);

        return $this;
    }

    public function getTruncate()
    {
        $truncate = $this->client->isTruncateEnabled();

        return array_get(array_flip($this->truncateActions), $truncate);
    }

    public function setInvalidCharAction($action)
    {
        $action = array_get($this->invalidCharActions, $action);

        $this->client->setInvalidCharAction($action);

        return $this;
    }

    public function getInvalidCharAction()
    {
        $action = $this->client->getInvalidCharAction();

        return array_get(array_flip($this->invalidCharActions), $action);
    }

    public function getBalance()
    {
        return $this->client->getBalance();
    }

    public function post($uri, $data)
    {
        return $this->client->makeRequest($uri, $data);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient(ClockworkClient $client)
    {
        $this->client = $client;

        return $this;
    }
}
