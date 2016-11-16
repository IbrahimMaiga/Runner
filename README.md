# Runner
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
$parameters['callback'] = function (){
    // Function Body
};
$runner = new \Runner\Engine\Runner($parameters);
$runner->run();
```
Function with parameters
```sh
$parameters = [];
$parameters['callback'] = function ($foo){
    // Function Body
};
$parameters['params'] = ['foo']
```

To run, just do it, you have biensur in the case of a callback function with the number of parameters given to this function is equal to the number of parameters in the table indexed by key 'params', otherwise throw exception

```sh
$runner = new \Runner\Engine\Runner($params);
$runner->run();
```
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

You specifies the value (class or callback methods previously created) of the keys defaults_r or callback_r in a YAML file, after the file path is given as the second constructor parameter to the Runner class.
```sh
$runner = new \Runner\Engine\Runner($params, path/to/yaml/file);
````

