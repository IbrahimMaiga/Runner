<?php

/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>
 */

namespace Runner\Engine;

/**
 * Class Runner
 * @package Routing\Runner
 */
class Runner
{
    /**
     * Defaults runner class name
     * @var array
     */
    private static $defaults = [
        'defaults_r' => 'Runner\Engine\DefaultsRunner',
        'callback_r' => 'Runner\Engine\CallBackRunner'
    ];

    /**
     * @var Runner
     */
    private static $singleton;

    /**
     * Parameters
     * @var array
     */
    private $params = array();

    /**
     * @var RunnerInterface
     */
    private $runner;

    /**
     * @var bool|string
     */
    private $available;

    /**
     * @var mixed
     */
    private $toInject;

    /**
     * @var bool|array
     */
    private $defineClasses;

    /**
     * Runner constructor.
     * @param array|string|null $file
     */
    public function __construct($file = null)
    {
        $this->defineClasses = $this->getClasses($file);
        if (!empty($this->defineClasses) and is_array($this->defineClasses)) {
            if (count($this->defineClasses) > 2) {
                throw new \RuntimeException('the array contains more values, the maximum number of value is two');
            } else {
                $array = array_filter($this->defineClasses, function ($key) {
                    return array_key_exists($key, self::$defaults);
                }, ARRAY_FILTER_USE_KEY);
                if (empty($array)) {
                    throw new \RuntimeException('incorrect key in file or array');
                }
            }
        }
        $this->defineClasses = array_merge(self::$defaults, $this->defineClasses);
    }

    /**
     * Run Runner
     * @param array $params the parameters containing the class to call,
     * the method or the callback and the parameters if exist
     * @return mixed
     */
    public function run(array $params)
    {
        $this->available = $this->resolveParams($params);
        if (!$this->available) {
            throw new \RuntimeException('parameters not found');
        }
        $_class = $this->defineClasses[$this->available];
        $this->runner = new $_class($this->params);
        $this->runner->injectIfExist($this->toInject);
        return $this->doRun($this->runner);
    }

    /**
     * @param RunnerInterface $runner the interface that allows to make operate action
     * @return string content returned by operate action
     */
    private function doRun(RunnerInterface $runner)
    {
        return $runner->operate();
    }

    /**
     * checks if the parameter is valid and corresponds what we want
     * @param array$params parameters
     * @return bool|string
     */
    private function resolveParams(array $params)
    {
        $available = false;
        if ($params) {
            if (!is_null($params) && !empty($params)) {

                if (isset($params['defaults'])) {
                    $defaults = explode(':', $params['defaults']);
                    if (count($defaults) === 2) {
                        $params['class'] = $defaults[0];
                        $params['action'] = $defaults[1];
                    } else {
                        throw new \RuntimeException("params length must be equals to two");
                    }
                }

                if (isset($params['class']) && isset($params['action'])) {
                    $this->unsetAll($params, 'class', 'action');
                    $available = 'defaults_r';
                } elseif (isset($params['callback'])) {
                    $this->unsetAll($params, 'callback');
                    $available = 'callback_r';
                }
                $this->params = $params;
            } else {
                throw new \RuntimeException("empty or null parameters");
            }
        }
        return $available;
    }

    /**
     * @param $file
     * @return array
     */
    private function getClasses($file)
    {
        if (!is_null($file)) {
            if (is_array($file)) {
                return $file;
            }
            $fileParts = explode('.', $file);
            if (count($fileParts) == 2) {
                $extension = $fileParts[1];
                return $extension === 'php' ? require_once "$file" : parse_ini_file($file);
            } else {
                throw new \RuntimeException('incorrect file');
            }
        }

        return [];
    }

    /**
     * @param $array
     * @param array ...$elements
     */
    private function unsetAll($array, ...$elements)
    {
        foreach ($elements as $element) {
            unset($array[$element]);
        }
    }

    /**
     * @param $toInject
     */
    public function injectIfExist($toInject)
    {
        $this->toInject = $toInject;
    }

    /**
     * Creates singleton instance
     * @param array|string|null $file
     * @return Runner
     */
    public static function singleton($file = null)
    {
        if (self::$singleton === null) {
            self::$singleton = self::create($file);
        }

        return self::$singleton;
    }

    /**
     * Creates this class instance
     * @param array|string|null $file
     * @return Runner
     */
    public static function create($file = null)
    {
        return new self($file);
    }

    /**
     * Run this, use singleton instance
     * @param array $params
     * @return mixed
     */
    public static function invokeRun(array $params)
    {
        return self::singleton()->run($params);
    }
}