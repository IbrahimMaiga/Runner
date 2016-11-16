<?php

/**
 * @author Ibrahim Maïga
 */


namespace Runner\Exception;

/**
 * Class CallBackRunnerException
 * @package Routing\Exception
 */
class CallBackRunnerException extends \Exception
{

    /**
     * CallBackRunnerException constructor.
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */

    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}