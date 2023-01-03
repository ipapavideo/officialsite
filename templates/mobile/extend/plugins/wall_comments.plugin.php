<?php
function template_plugin_wall_comments($wall_id)
{
	static $cmodel = null;
	
	if (!isset($cmodel) or !$cmodel) {
		$cmodel	= VModel::load('comment', 'profile');
	}

	return $cmodel->comments('c.wall_id = ? AND c.parent_id = 0 AND c.status = 1', 'i', $wall_id, VCfg::get('profile.comments_per_page'));
}
