<?php

/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>
 */


namespace Runner\Engine;

/**
 * Interface CallBackRunnerInterface
 * @package Runner\Engine
 */
interface CallBackRunnerInterface extends RunnerInterface
{
    public function setCallBack($callback);
}