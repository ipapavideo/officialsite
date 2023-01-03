<?php
function template_plugin_ctr_videos($ids)
{
	if (!VCfg::get('video.ctr') or !$ids) {
		return;
	}
	
	VF::factory('database')->query('
		UPDATE #__video_loads
		SET total_loads = total_loads+1,
		    today_loads = today_loads+1
		WHERE video_id IN ('.implode(',', array_values($ids)).')
		LIMIT '.count($ids),
		false,
		false,
		true
	);
}
