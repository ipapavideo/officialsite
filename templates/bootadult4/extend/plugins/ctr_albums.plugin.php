<?php
function template_plugin_ctr_albums($ids)
{
	if (!VCfg::get('photo.ctr') or !$ids) {
		return;
	}
	
    $count      = count($ids);
    $clause     = implode(',', array_fill(0, $count, '?'));
    $types		= implode('', array_fill(0, $count, 'i'));
	
	$db	= VF::factory('database');
	$db->prepare('
		UPDATE #__photo_albums_loads
		SET total_loads = total_loads+1,
		    today_loads = today_loads+1
		WHERE album_id IN ('.$clause.')
		LIMIT '.$count,
		$types,
		$ids
	);
}
