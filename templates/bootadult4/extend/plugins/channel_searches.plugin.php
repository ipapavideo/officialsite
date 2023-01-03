<?php
function template_plugin_channel_searches($name)
{
	$keyword	= utf8_strtolower($name);
	$pmodel		= VModel::load('popular', 'video');
	
	if ($keywords = $pmodel->searches($keyword, 20)) {
		return $keywords;
	}
	
	return array();
}
