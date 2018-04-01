<?php

/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>
 */


namespace Runner\Engine;

/**
 * Interface RunnerInterface
 * @package Runner\Engine
 */
interface RunnerInterface
{
    /**
     * @return string
     */
    public function operate();

    /**
     * @param $toInject
     * @return mixed
     */
    public function injectIfExist($toInject);
}