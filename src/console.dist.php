<?php

use Brisum\Lib\Console\Application;
use Brisum\Lib\ObjectManager;

define('CONSOLE_ROOT_DIR', realpath(__DIR__));

$_SERVER['SERVER_NAME'] = 'example.com';
$_SERVER['REQUEST_METHOD'] = 'CLI';

/** @var Application $application */
$application = ObjectManager::getInstance()->create('Brisum\Lib\Console\Application');
$application->run();
