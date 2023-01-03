<?php
function template_plugin_ctr_categories($ids, $type = 'video')
{
	$types	= array(
		'video'	=> 1,
		'photo'	=> 1
	);
	
	if (!isset($types[$type])) {
		return;
	}

	if (!VCfg::get($type.'.category_ctr') or !$ids) {
		return;
	}
	
    $count      = count($ids);
    $clause     = implode(',', array_fill(0, $count, '?'));
    $types		= implode('', array_fill(0, $count, 'i'));
	
	$db	= VF::factory('database');
	$db->prepare('
		UPDATE #__'.$type.'_categories_loads
		SET total_loads = total_loads+1,
		    today_loads = today_loads+1
		WHERE cat_id IN ('.$clause.')
		LIMIT '.$count,
		$types,
		$ids
	);
}
