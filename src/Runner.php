<?php

/**
 * @author Ibrahim Maïga
 */

namespace Runner\Engine;

use Symfony\Component\Yaml\Yaml;

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
    private $runnerInterface;

    private $available;

    private $defineClasses;
    /**
     * Runner constructor.
     * @param array $params
     * @param null $file
     */
    public function __construct(array $params, $file = null){
        $this->params = $params;
        $this->file = $file;
        $this->available = $this->resolveParams($params);
        $this->defineClasses = $this->getClasses($file);
    }

    /**
     * Run Runner
     * @return mixed
     */
    public function run(){
        $_class = is_null($this->file) ? self::$defaults[$this->available]
                                       : $this->defineClasses[$this->available];
        $this->runnerInterface = new $_class($this->params);
        return $this->doRun($this->runnerInterface);
    }

    /**
     * @param RunnerInterface $runner
     * @return mixed
     */
    private function doRun(RunnerInterface $runner){
        return $runner->operate();
    }

    /**
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    private function resolveParams($params)
    {
        if (!is_null($params) && !empty($params)){

            if (isset($params['defaults'])){
                $defaults = explode(':', $params['defaults']);
                if (count($defaults) ===  2){
                    $params['class'] = $defaults[0];
                    $params['action'] = $defaults[1];
                }
            }

            if (isset($params['class']) && isset($params['action'])){
                $this->delete($params, 'class', 'action');
                $available = 'defaults_r';
            }
            else if (isset($params['callback'])){
                $this->delete($params, 'callback');
                $available = 'callback_r';
            }
            else
                return null;

            return $available;
        }

        return null;
    }


    /**
     * @param $file
     * @return mixed
     */
    private function getClasses($file)
    {
        if (!is_null($file)) {
            try {
                return Yaml::parse(file_get_contents($this->file));
            } catch (ParseException $e) {
                trigger_error(sprintf("Unable to parse the YAML string: %s", $e->getMessage()));
            }
        }

        return null;
    }

    /**
     * @param $array
     * @param array ...$elements
     */
    private function delete($array, ...$elements)
    {
        foreach ($elements as $element)
        {
            unset($array[$element]);
        }
    }
}