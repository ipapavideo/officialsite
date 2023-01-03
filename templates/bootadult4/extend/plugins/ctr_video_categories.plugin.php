<?php
function template_plugin_ctr_video_categories($ids)
{
	if (!VCfg::get('video.category_ctr') or !$ids) {
		return;
	}
	
	VF::factory('database')->query('
		UPDATE #__video_categories_loads
		SET total_loads = total_loads+1,
		    today_loads = today_loads+1
		WHERE cat_id IN ('.implode(',', array_values($ids)).')
		LIMIT '.count($ids),
		false,
		false,
		true
	);
}
