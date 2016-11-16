<?php

/**
 * @author Ibrahim Maïga
 */

namespace Runner\Engine;


class DefaultsRunner implements DefaultsRunnerInterface
{
    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $params;

    /**
     * @var array|bool
     */
    private $parameters;

    public function __construct($parameters){
        $this->parameters = $parameters;
        if (!is_null($parameters)){
            $this->controller = $this->get($parameters, 'controller');
            $this->action = $this->get($parameters, 'action');
            $this->params = $this->get($parameters, 'params');
        }
    }

    private function get($parameters, $key){
        return isset($parameters[$key]) ? $parameters[$key] : null;
    }

    /**
     * @param $controller
     */
    public function setController($controller){
        if (is_string($controller)){
            $this->controller = $controller;
        }
    }

    /**
     * @param $action
     */
    public function setAction($action){
        if (is_string($action)){
            $this->action = $action;
        }
    }

    public function operate(){
        return $this->executeDefaults($this->controller, $this->action, $this->params);
    }

    /**
     * @param $controller controller to call
     * @param $action controller method to call
     * @param $params method parameters
     * @return returns the value returned by the callback function, false otherwise
     */
    private function executeDefaults($controller, $action, $params){
        return call_user_func_array(array(new $controller(), $action), $params);
    }
}