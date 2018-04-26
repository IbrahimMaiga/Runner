<?php


namespace Runner\Tests;
require_once 'elements/FakeClass.php';
require_once 'elements/FakeEmptyClass.php';
require_once 'elements/ToInject.php';
require_once 'elements/ToInject1.php';
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

    /**
     * @var Runner
     */
    private $instance;

    protected function setUp() {
        $this->instance = Runner::singleton();
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
        $params['params'] = [2];
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

    public function testRunWithDefaultsKeyNotExistInParams() {
        $this->expectException(\RuntimeException::class);
        Runner::singleton()->run(['default' => 'Runner\Tests\FakeEmptyClass:id']);
    }

    public function testRunWithDefaultsKeyExistInParams() {
        $this->expectOutputString('Okay');
        Runner::singleton()->run(['defaults' => 'Runner\Tests\FakeEmptyClass:result']);
    }

    public function testRunWithDefaultsKeyExistInParamsWithResult() {
        $params = [];
        $params['class'] = 'Runner\Tests\FakeEmptyClass';
        $params['action'] = 'id';
        $this->assertEquals(Runner::invokeRun($params), 0);
    }

    public function testRunWithDefaultsKeyExistInParamsWithOutput() {
        $this->expectOutputString('Okay');
        $params = [];
        $params['class'] = 'Runner\Tests\FakeEmptyClass';
        $params['action'] = 'result';
        Runner::invokeRun($params);
    }

    public function testRunWithCallBackKeyNotExistInParams() {
        $this->expectException(\RuntimeException::class);
        Runner::singleton()->run(['call' => function () {
            echo 'RuntimeException';
        }]);
    }

    public function testRunWithCallBackKeyExistInParamsWithResult() {
        $result = Runner::singleton()->run(['callback' => function () {
            return 'Okay';
        }]);
        $this->assertEquals($result, 'Okay');
    }

    public function testRunWithCallBackKeyExistInParamsWithOutput() {
        Runner::singleton()->run(['callback' => function () {
            echo 'Okay';
        }]);
        $this->expectOutputString('Okay');
    }

    public function testRunWithDefaultsKeyExistInParamValue() {
        $this->expectException(\RuntimeException::class);
        Runner::singleton()->run(['defaults' => 'Runner\Tests\FakeEmptyClass:id:di']);
    }

    public function testRunWithDefaultsKeyExistWithEmptyParams() {
        $this->expectException(\RuntimeException::class);
        Runner::singleton()->run([]);
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetClassesWithNullParams() {
        $this->assertEquals($this->invokeNoVisibleMethod($this->instance,
            'getClasses', [null]), []);
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetClassesWithArrayInParams() {
        $this->assertEquals($this->invokeNoVisibleMethod($this->instance,
            'getClasses', [['foo']]), ['foo']);
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetClassesWithPhpFileInParams() {
        $this->assertEquals($this->invokeNoVisibleMethod($this->instance,
            'getClasses', [FIXTURE_PATH . '/file.php']), [
            'defaults_r' => 'Runner\Tests\DefaultsCallBack',
            'callback_r' => 'Runner\Tests\ExampleCallBack'
        ]);
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetClassesWithPhpFileInParamsWithIncorrectReturnValue() {
        $this->expectException(\RuntimeException::class);
        $this->invokeNoVisibleMethod($this->instance,
            'getClasses', [FIXTURE_PATH . '/file1.php']);
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetClassesWithIniFileInParams() {
        $this->assertEquals($this->invokeNoVisibleMethod($this->instance,
            'getClasses', [FIXTURE_PATH . '/file.ini']), [
            'defaults_r' => 'Runner\Tests\DefaultsCallBack',
            'callback_r' => 'Runner\Tests\ExampleCallBack'
        ]);
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetClassesInParamsWithIncorrectTypeFileWithExtension() {
        $this->expectException(\RuntimeException::class);
        $this->invokeNoVisibleMethod($this->instance,
            'getClasses', [FIXTURE_PATH . '/file.yml']);
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetClassesInParamsWithIncorrectTypeFileWithoutExtension() {
        $this->expectException(\RuntimeException::class);
        $this->invokeNoVisibleMethod($this->instance,
            'getClasses', [FIXTURE_PATH . '/file']);
    }

    public function testConstructorWithMoreValuesInFile() {
        $this->expectException(\RuntimeException::class);
        Runner::create(FIXTURE_PATH . '/more_elements.php');
    }

    public function testConstructorWithMoreValuesInArray() {
        $this->expectException(\RuntimeException::class);
        Runner::create([
            'defaults_r' => 'Runner\Tests\DefaultsCallBack',
            'callback_r' => 'Runner\Tests\ExampleCallBack',
            'callback_1' => 'Runner\Tests\ExampleCallBack'
        ]);
    }

    public function testConstructorWithCorrectValuesCountButIncorrectKeyInArray() {
        $this->expectException(\RuntimeException::class);
        Runner::create([
            'defaults_r' => 'Runner\Tests\DefaultsCallBack',
            'callback_1' => 'Runner\Tests\ExampleCallBack'
        ]);
    }

    public function testWithInjectObject() {
        $toInject = new ToInject();
        $params = [];
        $params['class'] = 'Runner\Tests\FakeClass';
        $params['action'] = 'injection';
        $params['params'] = [2];
        $instance = Runner::createFrom([$toInject]);
        $this->assertEquals($instance->run($params), 2);
    }

    public function testWithInjectObjectArray() {
        $toInject = new ToInject();
        $params = [];
        $params['class'] = 'Runner\Tests\FakeClass';
        $params['action'] = 'injection';
        $params['params'] = [2];
        $instance = Runner::createFrom([$toInject]);
        $this->assertEquals($instance->run($params), 2);
    }

    public function testWithInjectObjectArrayWithCountEquals2() {
        $toInject = new ToInject();
        $toInject1 = new ToInject1();
        $params = [];
        $params['class'] = 'Runner\Tests\FakeClass';
        $params['action'] = 'injection2';
        $params['params'] = [2];
        $instance = Runner::createFrom([$toInject, $toInject1]);
        $this->assertEquals($instance->run($params), 2);
    }

    /**
     * Calls private and protected methods
     * @param $instance
     * @param $method
     * @param array $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    private function invokeNoVisibleMethod(&$instance, $method, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($instance));
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);
        return $method->invokeArgs($this->instance, $parameters);
    }
}