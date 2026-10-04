<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function web_prefix()
{
	$script = isset($_SERVER['SCRIPT_NAME']) ? str_replace('\\', '/', $_SERVER['SCRIPT_NAME']) : '';
	$dir = str_replace('\\', '/', dirname($script));
	$dir = rtrim($dir, '/');

	if ($dir === '' OR $dir === '.' OR $dir === '/')
	{
		return '';
	}

	return $dir;
}

function page_url($path = '', $trailing_slash = TRUE)
{
	$path = trim($path, '/');
	$prefix = web_prefix();

	if ($path === '')
	{
		return ($prefix === '' ? '/' : $prefix.'/');
	}

	$url = $prefix.'/'.$path;

	return $trailing_slash ? $url.'/' : $url;
}

function asset_url($path)
{
	$path = ltrim($path, '/');
	$full = FCPATH.'assets/'.str_replace('/', DIRECTORY_SEPARATOR, $path);
	$href = web_prefix().'/assets/'.$path;

	if (is_file($full))
	{
		$href .= '?v='.filemtime($full);
	}

	return $href;
}

function canonical_url($path = '', $trailing_slash = TRUE)
{
	$https = ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
		OR (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
	$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '127.0.0.1';

	return ($https ? 'https' : 'http').'://'.$host.page_url($path, $trailing_slash);
}

function format_date($iso)
{
	$ts = strtotime($iso);

	return $ts ? date('F j, Y', $ts) : $iso;
}

function nav_is_current($path)
{
	return trim(uri_string(), '/') === trim($path, '/');
}
