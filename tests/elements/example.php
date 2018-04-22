<?php

/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>
 */

require_once '../../vendor/autoload.php';

$params = [];
$params['class'] = 'Runner\Tests\FakeClass';
$params['action'] = 'id';
$params['params'] = [2];
echo \Runner\Engine\Runner::singleton('file.ini')->run($params);