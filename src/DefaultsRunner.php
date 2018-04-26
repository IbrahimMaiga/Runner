<?php

/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>
 */

namespace Runner\Engine;

use Runner\Exception\DefaultsRunnerException;
use Runner\InjectionUtils;

/**
 * Class DefaultsRunner
 * @package Runner\Engine
 */
class DefaultsRunner implements DefaultsRunnerInterface, DefaultValue
{
    use InjectionUtils;
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
     * @var array
     */
    private static $classesInstance = [];

    /**
     * @var mixed
     */
    private $toInject;

    /**
     * DefaultsRunner constructor.
     * @param $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        if (isset($parameters['class']) and isset($parameters['action'])) {
            $this->setClass($parameters['class'])->setAction($parameters['action']);
            $this->params = $parameters['params'] ?? [];
        }
    }

    /**
     * @param $_class
     * @return DefaultsRunner
     */
    public function setClass($_class)
    {
        if (!is_string($_class)) {
            throw new DefaultsRunnerException('class name must be a string');
        }
        $this->_class = $_class;
        return $this;
    }

    /**
     * @param $action
     * @return DefaultsRunner
     */
    public function setAction($action)
    {
        if (!is_string($action)) {
            throw new DefaultsRunnerException('action must be a string');
        }
        $this->action = $action;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function operate()
    {
        return $this->executeDefaults($this->_class, $this->action, $this->params);
    }

    /**
     * @param string $_class string _class to call
     * @param string $action string _class method to call
     * @param array $params array method parameters
     * @return mixed the value returned by the callback function, false otherwise
     */
    private function executeDefaults(string $_class, string $action, array $params)
    {
        if (!is_null($_class) && !is_null($action)) {
            $method = 'call_user_func';
            if (is_array($params)) $method .= '_array';
            if (!is_null($this->toInject)) {
                $params = array_merge($this->doInjection($this->toInject, $_class, $action), $params);
            }
            if (!array_key_exists($_class, self::$classesInstance)) {
                self::$classesInstance[$_class] = new $_class();
            }
            return $method([self::$classesInstance[$_class], $action], $params);
        }
        return false;
    }

    public function inject($toInject)
    {
        $this->toInject = $toInject;
    }
}