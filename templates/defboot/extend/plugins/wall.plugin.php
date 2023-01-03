<?php
function template_plugin_wall($wall_id)
{
	static $wmodel = null;
	
	if (!isset($wmodel) or !$wmodel) {
		$wmodel	= VModel::load('wall', 'profile');
	}

	return $wmodel->get($wall_id);
}
