<?php namespace Genetsis\Druid\Exceptions;

use Exception;

class NotConnectedException extends Exception
{
    /**
     * The redirect to path if user is Not Connected
     *
     * @var array
     */
    protected $redirect_to;

    public function __construct($redirect_to)
    {
        parent::__construct('User Not Connected to Druid');

        $this->redirect_to = $redirect_to;
    }

    /**
     * Get the redirect to path
     *
     * @return array
     */
    public function redirect_to()
    {
        return $this->redirect_to;
    }
}