<?php
/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */

namespace Runner\Tests;


use Runner\Engine\DefaultsRunnerInterface;

class ExampleDefaults implements DefaultsRunnerInterface
{
    private $_class;
    private $action;

    /**
     * @return mixed
     */
    public function operate() {
        return 'ExampleDefaults';
    }

    /**
     * @param $toInject
     * @return mixed
     */
    public function injectIfExist($toInject)
    {
       return null;
    }

    /**
     * @param $_class
     */
    public function setClass($_class)
    {
        $this->_class = $_class;
    }

    /**
     * @param $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
}