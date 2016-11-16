<?php

/**
 * @author Ibrahim Maïga
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
     * @var Closure
     */
    private $callback;

    /**
     * @var array
     */
    private $params = array();

    /**
     * CallBackRunner constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;
        if (isset($this->params['callback']))
            $this->setCallBack($this->params['callback']);
    }

    /**
     * @param \Closure $callback
     * @return $this the current instance
     * @throws CallBackRunnerException
     */
    public function setCallBack($callback){
        if ($callback instanceof \Closure)
            $this->callback = $callback;
        else
            throw new CallBackRunnerException("the index callback must be a Closure");
    }


    /**
     * @return mixed
     * @throws CallBackRunnerException
     */
    public function operate()
    {
        if (!is_null($this->callback))
           return $this->executeMethod($this->callback, $this->params);

        throw new CallBackRunnerException(sprintf("null closure"));
    }

    /**
     * @param $callback
     * @param $params
     * @return mixed
     */
    private function executeMethod($callback, $params){
        return call_user_func($callback, $params);
    }
}