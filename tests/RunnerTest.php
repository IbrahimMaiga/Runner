<?php


namespace Runner\Tests;
require_once 'elements/FakeClass.php';
require_once 'elements/FakeEmptyClass.php';
/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */

use PHPUnit\Framework\TestCase;
use Runner\Engine\Runner;

/**
 * Class RunnerTest
 */
class RunnerTest extends TestCase
{

    protected function setUp() {
    }

    public function testRunWithCallBackPrimitiveParam() {
        $params = [];
        $params['callback'] = function ($kf): string {
            return "Hi $kf!";
        };
        $params['params'] = 'Kanfa';
        $this->assertEquals(Runner::invokeRun($params), "Hi Kanfa!");
    }

    public function testRunWithCallBackArrayParam() {
        $params = [];
        $params['callback'] = function ($kf): string {
            return "Hi $kf!";
        };
        $params['params'] = ['Kanfa'];
        $this->assertEquals(Runner::invokeRun($params), "Hi Kanfa!");
    }

    public function testRunWithCallBackAssociativeArrayParam() {
        $params = [];
        $params['callback'] = function ($kf): string {
            return "Hi $kf!";
        };
        $params['params'] = ['kf' => 'Kanfa'];
        $this->assertEquals(Runner::invokeRun($params), "Hi Kanfa!");
    }

    public function testRunWithCallBackEmptyParam() {
        $params = [];
        $params['callback'] = function (): string {
            return "Hi Kanfa!";
        };
        $this->assertEquals(Runner::invokeRun($params), "Hi Kanfa!");
    }

    public function testRunWithDefaultsPrimitiveParam() {
        $params = [];
        $params['class'] = 'Runner\Tests\FakeClass';
        $params['action'] = 'id';
        $params['params'] = 2;
        $this->assertEquals(Runner::invokeRun($params), 2);
    }

    public function testRunWithDefaultsArrayParam() {
        $params = [];
        $params['class'] = 'Runner\Tests\FakeClass';
        $params['action'] = 'id';
        $params['params'] = [2];
        $this->assertEquals(Runner::invokeRun($params), 2);
    }

    public function testRunWithDefaultsAssociativeArrayParam() {
        $params = [];
        $params['class'] = 'Runner\Tests\FakeClass';
        $params['action'] = 'id';
        $params['params'] = ['id' => 2];
        $this->assertEquals(Runner::invokeRun($params), 2);
    }

    public function testRunWithDefaultsEmptyParam() {
        $params = [];
        $params['class'] = 'Runner\Tests\FakeEmptyClass';
        $params['action'] = 'id';
        $this->assertEquals(Runner::invokeRun($params), 0);
    }
}