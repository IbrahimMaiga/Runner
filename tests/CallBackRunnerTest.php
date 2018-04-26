<?php
/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */

namespace Runner\Tests;


use PHPUnit\Framework\TestCase;
use Runner\Engine\CallBackRunner;
use Runner\Exception\CallBackRunnerException;

class CallBackRunnerTest extends TestCase
{

    public function testSetCallBackNotInstanceOfClosure()
    {
        $this->expectException(CallBackRunnerException::class);
        new CallBackRunner(['callback' => '']);
    }

    public function testSetCallBackInstanceOfClosure()
    {
        $func = function () {
            echo 'Okay';
        };
        $callbackRunner = (new CallBackRunner([]))->setCallBack($func);
        $this->assertInstanceOf(CallBackRunner::class, $callbackRunner);
    }

    public function testOperateIfCallBackIsNull()
    {
        $this->expectException(CallBackRunnerException::class);
        (new CallBackRunner(['callback' => null]))->operate();
    }

    public function testOperateWithCorrectValueAndEmptyParams()
    {
        $this->expectOutputString('Okay');
        (new CallBackRunner(['callback' => function () {
            echo 'Okay';
        }]))->operate();
    }

    public function testOperateWithCorrectValueAndParams()
    {
        $this->expectOutputString('My Id 1');
        (new CallBackRunner(['callback' => function ($id) {
            echo 'My Id ' . $id;
        }, 'params' => 1]))->operate();
    }
}