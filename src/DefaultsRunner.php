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
        if (!is_null($this->parameters)) {
            $this->_class = $this->get('class');
            $this->action = $this->get('action');
            $this->params = $this->get('params');
        } else {
            throw new \RuntimeException('null parameters');
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    private function get($key)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
    }

    /**
     * @param $_class
     * @return DefaultsRunner
     */
    public function setClass($_class)
    {
        if (is_string($_class)) {
            throw new \InvalidArgumentException('class name must be a string');
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
            throw new \InvalidArgumentException('action must be a string');
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
     * @param $_class string _class to call
     * @param $action string _class method to call
     * @param $params array method parameters
     * @return mixed the value returned by the callback function, false otherwise
     */
    private function executeDefaults($_class, $action, $params)
    {
        if (!is_null($_class) && !is_null($action)) {
            $method = 'call_user_func';
            if (is_array($params)) $method .= '_array';
            if (array_key_exists($_class, self::$classesInstance)) {
                $instance = self::$classesInstance[$_class];
            } else {
                if (!is_null($this->toInject)) {
                    try {
                        $reflection = new \ReflectionClass($_class);
                        $reflectionMethod = $reflection->getMethod($action);
                        $reflectionMethodParams = $reflectionMethod->getParameters();
                        if (is_object($this->toInject)) {
                            $className = get_class($this->toInject);
                            foreach ($reflectionMethodParams as $reflectionMethodParam) {
                                if ($reflectionMethodParam->getClass() != null and $reflectionMethodParam->getClass()->getName() == $className) {
                                    $instanceToInject = $this->toInject;
                                }
                            }
                        } else {
                            $instanceToInject = new $this->toInject;
                        }

                        if (isset($instanceToInject)) {
                            $params = array_merge($params, [$instanceToInject]);
                        }

                    } catch (\ReflectionException $e) {
                        trigger_error(sprintf('the class %s does not exist', $_class));
                    }
                }
                $instance = new $_class();
                self::$classesInstance[$_class] = $instance;
            }
            return $method([$instance, $action], $params);
        }
        return false;
    }

    public function injectIfExist($toInject)
    {
        $this->toInject = $toInject;
    }
}