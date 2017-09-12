<?php

/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>
 */


namespace Runner\Engine;

/**
 * Interface DefaultsRunnerInterface
 * @package Runner\Engine
 */
interface DefaultsRunnerInterface extends RunnerInterface
{
    /**
     * @param $_class
     */
    public function setClass($_class);

    /**
     * @param $action
     */
    public function setAction($action);
}