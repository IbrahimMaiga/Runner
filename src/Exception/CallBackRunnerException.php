<?php

/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>
 */


namespace Runner\Exception;

/**
 * Class CallBackRunnerException
 * @package Routing\Exception
 */
class CallBackRunnerException extends \RuntimeException
{

    /**
     * CallBackRunnerException constructor.
     * @param string $message
     * @param int $code
     * @param \RuntimeException $previous
     */

    public function __construct($message, $code = 0, \RuntimeException $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}