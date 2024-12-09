<?php

spl_autoload_register(function ($class) {
	$src = $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class . '.php';
	if (file_exists($src)) {
		include $src;
	}
});

function custom_error_handler($errno, $errstr, $errfile, $errline)
{
	$db = new Database('logs.json');
	$db->add(['time' => time(), 'log' => $errstr]);
	$db->write();

	return false;
}

set_error_handler('custom_error_handler');