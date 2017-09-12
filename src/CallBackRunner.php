<?php

/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>
 */


namespace Runner\Engine;


use Runner\Exception\CallBackRunnerException;

/**
 * Class CallBackRunner
 * @package Routing\Runner
 */
class CallBackRunner implements CallBackRunnerInterface
{
    /**
     * @var \Closure
     */
    private $callback;

    /**
     * @var array
     */
    private $params = array();

    /**
     * @var array
     */
    private $parameters = array();

    /**
     * CallBackRunner constructor.
     * @param $parameters
     */
    public function __construct(array $parameters) {
        $this->parameters = $parameters;
        if (isset($this->parameters['callback'])) {
            $this->setCallBack($this->parameters['callback']);
        }
        if (isset($this->parameters['params'])) {
            $this->params = $parameters['params'];
        }
    }

    /**
     * @param \Closure $callback
     * @return $this the current instance
     * @throws CallBackRunnerException
     */
    public function setCallBack($callback) {
        if ($callback instanceof \Closure) {
            $this->callback = $callback;
        } else {
            throw new CallBackRunnerException("the index callback must be a Closure");
        }
        return $this;
    }


    /**
     * @return mixed
     * @throws CallBackRunnerException
     */
    public function operate() {
        if (!is_null($this->callback)) {
            return $this->executeMethod($this->callback, $this->params);
        }
        throw new CallBackRunnerException(sprintf("null closure"));
    }

    /**
     * @param $callback
     * @param $params
     * @return mixed
     */
    private function executeMethod($callback, $params) {
        $method = 'call_user_func';
        if (is_array($params)) $method .= '_array';
        return $method($callback, $params);
    }
}