<?php

/**
 * @author Ibrahim Maïga
 */


namespace Runner\Engine;


interface DefaultsRunnerInterface extends RunnerInterface
{
    /**
     * @param $controller
     */
    public function setController($controller);

    /**
     * @param $action
     */
    public function setAction($action);
}