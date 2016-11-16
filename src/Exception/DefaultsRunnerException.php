<?php

/**
 * @author Ibrahim Maïga.
 */


namespace Runner\Exception;

/**
 * Class DefaultsRunnerException
 * @package Routing\Exception
 */
class DefaultsRunnerException extends \Exception
{
    /**
     * DefaultsRunnerException constructor.
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message, $code = 0, Exception $previous)
    {
        parent::__construct($message, $code, $previous);
    }

}