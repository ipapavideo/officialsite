<?php
defined('_VALID') or die('Restricted Access!');
function template_plugin_benchmark($name)
{
	$benchmark 	= VBenchmark::get($name);
	return '<div style="width: 100%; text-align: center;">Rendered in '.$benchmark['time'].' seconds, using '.$benchmark['memory'].' memory!</div>';
}