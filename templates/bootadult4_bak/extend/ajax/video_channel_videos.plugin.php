<?php
function ajax_plugin_video_channel_videos()
{
    if (!isset($_GET['id'])) {
  		return;
    }

    VLanguage::load('frontend.video');
    		        
    $filter		= VF::factory('filter');
    $video_id	= $filter->get('id', 'INT', 'GET');
    
    $db	= VF::factory('database');
    $db->prepare('
  		SELECT v.channel_id, c.name
  		FROM #__video AS v
  		LEFT JOIN #__channel AS c ON (c.channel_id = v.channel_id AND c.status = 1)
  		WHERE v.video_id = ?
  		AND v.status = 1
  		LIMIT 1',
  		'i',
  		$video_id
  	);
  	
  	if (!$db->num_rows()) {
  		return;
  	}
  	
  	$video	= $db->fetch_assoc();
    
    $db->prepare('
  		SELECT '.implode(',', VData::get('columns', 'video')).'
  		FROM #__video AS v
  		LEFT JOIN #__channel AS ch ON (ch.channel_id = v.channel_id AND ch.status = 1)
        LEFT JOIN #__user AS u ON (u.user_id = v.user_id AND u.status = 1)
        WHERE v.channel_id = ?
        AND v.video_id != ?
        AND v.status = 1
        ORDER BY v.add_time DESC
        LIMIT '.VCfg::get('video.view_per_page'),
        'ii',
        array($video['channel_id'], $video_id)
    );
    
    if (!$videos = $db->fetch_rows()) {
  		return '<div class="none">'.__('no-channel-videos', $video['name']).'</div>';
    }
    
    VF::factory('template');

    $code       = array();
    $code[]     = p('adv', 'video-related-native', false, 'adv-native');
    $code[]     = p('videos', $videos, '-channel', false, false, true);
    
	return implode('', $code);
}
