# Runner [![Build Status](https://travis-ci.org/Kanfa/Runner.svg?branch=master)](https://travis-ci.org/Kanfa/Runner)
Runner is a simple library that run dynamically a callback function, or an accessible method of a class by giving the parameters if require.

# How to use

It creates an array with the following keys:
- "callback" to indicate a callback function
- "class" to indicate the name of a class
- "action" to indicate the name of a method belonging to the instance of the class name indicate as the value for the key "class"
- "params" to indicate the parameters to call

**Callback**

Calling a function without parameters
```sh
$parameters = [];
$parameters['callback'] = function () {
    echo 'Function Body';
};
$runner = new \Runner\Engine\Runner($parameters);
$runner->run();
```
Function with parameters
```sh
$parameters = [];
$parameters['callback'] = function ($foo) {
    echo 'Function Body';
};
$parameters['params'] = ['foo']
```

To run, just do it, you have of course in the case of a callback function with the number of parameters given to this function is equal to the number of parameters in the table indexed by key 'params', otherwise throw exception

```sh
$runner = new \Runner\Engine\Runner();
$runner->run($params);
```
or simply do

```sh
Runner\Engine\Runner::invokeRun($params);
```


You can add objects to inject as default parameters when create
 runner instance as follow
 
if you want to use the default configuration
 ```sh
 $runner =  Runner\Engine\Runner::createForm(new Class\To\Inject());
 ```
 otherwise
 ```sh
 $runner =  Runner\Engine\Runner::create('path/to/ini_or_php/file', new Class\To\Inject());
 ```
 this does not work for callback calls
 
**Class Method**

Same as above, except that instead of a given function of recalls, we give a class name and a method name, if the method exists, it will be called if an exception is thrown
```sh
$parameters = [];
$parameters['class'] = '\ClassNamespace\FakeClass'
$parameters['action']) = 'find';
$parameters['params'] = ['id']

<?php

namespace ClassNamespace
class FakeClass
{
    public function find($id)
    {
        echo "I found the element matching Id : $id"
    }
}

?>
```

**Use custom class defaults or callback**

You specifies the value (class or callback methods previously created) of the keys defaults_r or callback_r in a INI file, after the file path is given as the second constructor parameter to the Runner class.
```sh
$runner = new \Runner\Engine\Runner(path/to/ini_or_php/file);
````

_Other way to create instance_
```sh
$runner = \Runner\Engine\Runner::create(path/to/ini_or_php/file);
````


_Singleton_
```sh
$runner = \Runner\Engine\Runner::singleton(path/to/ini_or_php/file);
````

We can pass a table instead ini or php file

**INI file**
```sh
default_r = \Custom\DefaultsRunner\FakeClass
callback_r = \Custom\CallbackRunner\FakeClass
````

**PHP file**
```sh
<?php

return [
    'default_r' => '\Custom\DefaultsRunner\FakeClass'
    'callback_r' => '\Custom\CallbackRunner\FakeClass'
];
````

