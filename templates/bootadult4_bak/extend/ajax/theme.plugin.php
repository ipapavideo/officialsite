<?php
function ajax_plugin_theme()
{
	$data = array('status' => 0, 'url' => '', 'msg' => '', 'debug' => '');
	
    $filter     = VF::factory('filter');
    $theme		= $filter->get('theme');
    $current	= VCfg::get('template.bootadult4.colors');
    $search		= (strpos($theme, 'light') !== false) ? 'dark' : 'light';
    
    $new_theme	= str_replace($search, $theme, $current);
    
	VSession::set('theme', $new_theme);
	
	$data['status']	= 1;
	
	return json_encode($data);	
}
