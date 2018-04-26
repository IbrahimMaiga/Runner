<?php
/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */

namespace Runner\Tests;
require_once 'elements/FakeClass.php';
require_once 'elements/ToInject.php';

use PHPUnit\Framework\TestCase;
use Runner\Engine\DefaultsRunner;
use Runner\Exception\DefaultsRunnerException;

class DefaultsRunnerTest extends TestCase
{

    public function testSetClassWithIncorrectValueType() {
        $this->expectException(DefaultsRunnerException::class);
        (new DefaultsRunner([]))->setClass(1);
    }

    public function testSetClassWithCorrectValueType() {
        $this->assertInstanceOf(DefaultsRunner::class, (new DefaultsRunner([]))->setClass('string'));
    }

    public function testSetActionWithIncorrectValueType() {
        $this->expectException(DefaultsRunnerException::class);
        (new DefaultsRunner([]))->setAction(new \stdClass());
    }

    public function testSetActionWithCorrectValueType() {
        $this->assertInstanceOf(DefaultsRunner::class, (new DefaultsRunner([]))->setAction('string'));
    }

    public function testInject() {
        $toInject = new ToInject();
        $params = [];
        $params['class'] = 'Runner\Tests\FakeClass';
        $params['action'] = 'injection';
        $params['params'] = [2];
        $defaultRunner = new DefaultsRunner($params);
        $defaultRunner->inject($toInject);
        $this->assertEquals($defaultRunner->operate(), 2);
    }

    public function testInjectWithNotExistingClass() {
        $this->expectException(\RuntimeException::class);
        $toInject = new ToInject();
        $params = [];
        $params['class'] = 'Runner\Tests\FakeClass1';
        $params['action'] = 'injection';
        $params['params'] = [2];
        $defaultRunner = new DefaultsRunner($params);
        $defaultRunner->inject($toInject);
        $defaultRunner->operate();
    }
}