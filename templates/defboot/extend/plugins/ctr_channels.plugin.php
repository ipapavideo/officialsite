<?php
function template_plugin_ctr_channels($ids)
{
	if (!VCfg::get('channel.ctr') or !$ids) {
		return;
	}
	
    $count      = count($ids);
    $clause     = implode(',', array_fill(0, $count, '?'));
    $types		= implode('', array_fill(0, $count, 'i'));
	
	$db	= VF::factory('database');
	$db->prepare('
		UPDATE #__channel_loads
		SET total_loads = total_loads+1,
		    today_loads = today_loads+1
		WHERE channel_id IN ('.$clause.')
		LIMIT '.$count,
		$types,
		$ids
	);
}
