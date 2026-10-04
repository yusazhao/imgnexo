<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__.str_replace('/', DIRECTORY_SEPARATOR, $uri);

if ($uri !== '/' && is_file($file))
{
	return FALSE;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__.'/index.php';
