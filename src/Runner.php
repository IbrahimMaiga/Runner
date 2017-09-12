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
     * Parameters
     * @var array
     */
    private $params = array();

    /**
     * @var string
     */
    private $file;

    /**
     * @var RunnerInterface
     */
    private $runner;

    /**
     * @var bool|string
     */
    private $available;

    /**
     * @var bool|array
     */
    private $defineClasses;
    /**
     * Runner constructor.
     * @param array $params
     * @param null $file
     */
    public function __construct(array $params, $file = null) {
        $this->params = $params;
        $this->file = $file;
        $this->available = $this->resolveParams($params);
        $this->defineClasses = is_null($file) ? false : $this->getClasses($file);
    }

    /**
     * Run Runner
     * @return mixed
     */
    public function run() {
        $_class = !$this->defineClasses ? self::$defaults[$this->available] : $this->defineClasses[$this->available];
        $this->runner = new $_class($this->params);
        return $this->doRun($this->runner);
    }

    /**
     * @param RunnerInterface $runner
     * @return mixed
     */
    private function doRun(RunnerInterface $runner) {
        return $runner->operate();
    }

    /**
     * @param $params
     * @return bool|string
     */
    private function resolveParams($params) {
        if (!is_null($params) && !empty($params)) {

            if (isset($params['defaults'])) {
                $defaults = explode(':', $params['defaults']);
                if (count($defaults) ===  2){
                    $params['class'] = $defaults[0];
                    $params['action'] = $defaults[1];
                }
            }

            if (isset($params['class']) && isset($params['action'])) {
                $this->unset_all($params, 'class', 'action');
                $available = 'defaults_r';
            }
            elseif (isset($params['callback'])) {
                $this->unset_all($params, 'callback');
                $available = 'callback_r';
            } else $available = false;

        } else {
            trigger_error("Empty or null parameters");
            die();
        }
        return $available;
    }


    /**
     * @param $file
     * @return mixed
     */
    private function getClasses($file) {
        if (!is_null($file)) {
            return parse_ini_file($file, true);
        }

        return null;
    }

    /**
     * @param $array
     * @param array ...$elements
     */
    private function unset_all($array, ...$elements) {
        foreach ($elements as $element) {
            unset($array[$element]);
        }
    }
}