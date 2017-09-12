<?php

/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>
 */


namespace Runner\Exception;

/**
 * Class DefaultsRunnerException
 * @package Routing\Exception
 */
class DefaultsRunnerException extends \RuntimeException
{
    /**
     * DefaultsRunnerException constructor.
     * @param string $message
     * @param int $code
     * @param \RuntimeException $previous
     */
    public function __construct($message, $code = 0, \RuntimeException $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}