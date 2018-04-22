<?php
/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */

namespace Runner\Tests;


use Runner\Engine\CallBackRunnerInterface;

class ExampleCallBack implements CallBackRunnerInterface
{
    private $callback;
    public function setCallBack($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return mixed
     */
    public function operate() {
        return 'ExampleCallBack';
    }

    /**
     * @param $toInject
     * @return mixed
     */
    public function injectIfExist($toInject)
    {
       return null;
    }
}