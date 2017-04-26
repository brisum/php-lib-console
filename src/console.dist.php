<?php

use Brisum\Lib\ObjectManager;

define('CONSOLE_ROOT_DIR', realpath(__DIR__));

$_SERVER['SERVER_NAME'] = 'example.com';
$_SERVER['REQUEST_METHOD'] = 'CLI';

$artsy = ObjectManager::getInstance()->create('Brisum\Lib\Console\Application');
$artsy->run();
