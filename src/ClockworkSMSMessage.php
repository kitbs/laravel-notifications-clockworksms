<?php

namespace NotificationChannels\ClockworkSMS;

use MJErwin\Clockwork\Message;

class ClockworkSMSMessage implements ClockworkSMSMessageInterface
{
    /**
     * The message object.
     *
     * @var \MJErwin\Clockwork\Message
     */
    protected $message;

    /**
     * The names and aliases that will be passed to the message object
     * via __get, __set,  __call, __isset and __unset magic methods.
     *
     * @var \MJErwin\Clockwork\Message
     */
    protected $magicMethods = [
        'content' => 'Content',
        'from'    => 'FromName',
        'to'      => 'Number',
    ];

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct($content = '')
    {
        $this->message = new Message;
        $this->message->setContent($content);
    }

    /**
     * Retrieve a value from the message object.
     *
     * @param  string  $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($method = array_get($this->magicMethods, $name)) {
            $method = 'get'.$method;
            return $this->message->$method();
        }

        trigger_error('Undefined property: '.get_class($this).'::$'.$name);
    }

    /**
     * Whether a value is set on the message object.
     *
     * @param  string  $name
     * @return boolean
     */
    public function __isset($name)
    {
        if ($method = array_get($this->magicMethods, $name)) {
            $method = 'get'.$method;
            return (bool) $this->message->$method();
        }

        return false;
    }

    /**
     * Pass a value to the message object.
     *
     * @param  string  $name
     * @param  mixed  $value
     * @return void
     */
    public function __set($name, $value)
    {
        if ($method = array_get($this->magicMethods, $name)) {
            $method = 'set'.$method;
            $this->message->$method($val);
        }
    }

    /**
     * Unset/ null a value on the message object.
     *
     * @param  string  $name
     * @param  mixed  $value
     * @return void
     */
    public function __unset($name)
    {
        if ($method = array_get($this->magicMethods, $name)) {
            $method = 'set'.$method;
            $this->message->$method(null);
        }
    }

    /**
     * Pass a function call to the message object.
     *
     * @param  string  $func
     * @param  string  $val
     * @return mixed
     */
    public function __call($func, $val)
    {
        if ($method = array_get($this->magicMethods, $func)) {
            $method = 'set'.$method;
            $this->message->$method(head($val));
            return $this;
        }

        trigger_error('Uncaught Error: Call to undefined method '.get_class($this).'::'.$func.'()', E_USER_ERROR);

    }

    /**
     * Get the message object.
     *
     * @return \MJErwin\Clockwork\Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the message object.
     *
     * @param  \MJErwin\Clockwork\Message  $message
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

}
