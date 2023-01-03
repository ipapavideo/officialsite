<?php
function template_plugin_model_video_views($ids)
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
		SET video_views = video_views+1,
		    video_views_today = video_views_today+1,
		    video_views_week = video_views_week+1,
		    video_views_month = video_views_month+1,
		    video_views_year = video_views_year+1
		WHERE model_id IN ('.$clause.')
		LIMIT '.$count,
		$types,
		$ids
	);
}
