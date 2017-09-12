<?php
/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */

namespace Runner\Engine;


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
        return true;
    }
}