<?php
function template_plugin_channel_models($channel_id)
{
	$cache		= VF::factory('cache');
	$cache_id	= 'channel-models-'.$channel_id;
	$cache_ttl  = VCfg::get('channel.browse_ttl');
    $models   	= $cache->get($cache_id, $cache_ttl);
    if ($models === false) {
  		$columns	= VData::get('columns', 'model');

  		$db	= VF::factory('database');
  		$db->prepare('
  			SELECT '.implode(',', $columns).'
  			FROM #__model_videos AS mv
  			INNER JOIN #__model AS m ON (m.model_id = mv.model_id AND m.status = 1)
  			WHERE mv.video_id IN (SELECT video_id FROM #__video AS v WHERE v.channel_id = ? AND v.status = 1 ORDER BY v.total_views DESC)
  			GROUP BY m.model_id
  			LIMIT 7',
  			'i',
  			$channel_id
  		);
  		
  		$models	= $db->fetch_rows();
    }
    
    return ($models) ? $models : array();
}
