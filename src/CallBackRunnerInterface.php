<?php

/**
 * @author Ibrahim Maïga
 */


namespace Runner\Engine;


interface CallBackRunnerInterface extends RunnerInterface
{
    public function setCallBack($callback);
}