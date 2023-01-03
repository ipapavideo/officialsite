<?php
function template_plugin_model_album_views($ids)
{
	if (!$ids) {
		return;
	}
	
    $count      = count($ids);
    $clause     = implode(',', array_fill(0, $count, '?'));
    $types		= implode('', array_fill(0, $count, 'i'));
    
	$db	= VF::factory('database');
	$db->prepare('
		UPDATE #__model
		SET album_views = album_views+1,
		    album_views_today = album_views_today+1,
		    album_views_week = album_views_week+1,
		    album_views_month = album_views_month+1,
		    album_views_year = album_views_year+1
		WHERE model_id IN ('.$clause.')
		LIMIT '.$count,
		$types,
		$ids
	);
}
