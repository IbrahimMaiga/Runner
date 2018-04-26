<?php
/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */

namespace Runner;


trait InjectionUtils
{
    private static $injectionInstances = [];

    /**
     * @param object $toInject all objects to inject
     * @param string $class class name
     * @param string $action class method name
     * @return array instances to inject in method
     */
    private function doInjection($toInject, $class, $action)
    {
        try {
            $reflection = new \ReflectionClass($class);
            $reflectionMethod = $reflection->getMethod($action);
            $reflectionMethodParams = $reflectionMethod->getParameters();
            if (!is_array($toInject)) {
                $toInject = [$toInject];
            }
            $instancesToInject = [];
            if (is_array($toInject)) {
                $toInjectClassNames = [];
                foreach ($toInject as $inject) {
                    $toInjectClassNames[] = get_class($inject);
                }
                foreach ($reflectionMethodParams as $reflectionMethodParam) {
                    if ($reflectionMethodParam->getClass() !== null) {
                        $methodParamClass = $reflectionMethodParam->getClass()->getName();
                        if (in_array($methodParamClass, $toInjectClassNames)) {
                            $instancesToInject[] = new $methodParamClass;
                        }
                    }
                }
            }
            return $instancesToInject;
        } catch (\ReflectionException $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}