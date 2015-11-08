#!/usr/bin/env php
<?php

function my_autoloader($class) {
	include dirname(__FILE__).'/../src/' . str_replace("\\", "/", $class) . '.php';
}

spl_autoload_register('my_autoloader');

$client = new Integrity\Client();
$client->run();
