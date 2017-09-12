<?php

/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>
 */

namespace Runner\Engine;

/**
 * Class DefaultsRunner
 * @package Runner\Engine
 */
class DefaultsRunner implements DefaultsRunnerInterface
{
    /**
     * @var string
     */
    private $_class;

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

    /**
     * DefaultsRunner constructor.
     * @param $parameters
     */
    public function __construct(array $parameters) {
        $this->parameters = $parameters;
        if (!is_null($this->parameters)) {
            $this->_class = $this->get('class');
            $this->action = $this->get('action');
            $this->params = $this->get('params');
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    private function get($key) {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
    }

    /**
     * @param $_class
     */
    public function setClass($_class) {
        if (is_string($_class)) {
            $this->_class = $_class;
        } else {
            throw new \InvalidArgumentException('class name must be a string');
        }
    }

    /**
     * @param $action
     */
    public function setAction($action) {
        if (is_string($action)) {
            $this->action = $action;
        } else {
            throw new \InvalidArgumentException('action must be a string');
        }
    }

    public function operate() {
        return $this->executeDefaults($this->_class, $this->action, $this->params);
    }

    /**
     * @param $_class string _class to call
     * @param $action string _class method to call
     * @param $params array method parameters
     * @return mixed the value returned by the callback function, false otherwise
     */
    private function executeDefaults($_class, $action, $params) {
        if (!is_null($_class) && !is_null($action)) {
            $method = 'call_user_func';
            if (is_array($params)) $method .= '_array';
            return $method([new $_class(), $action], $params);
        }
        return false;
    }
}