<?php
function ajax_plugin_video_user_videos()
{
    if (!isset($_GET['id'])) {
  		return;
    }

    VLanguage::load('frontend.video');
    		        
    $filter		= VF::factory('filter');
    $video_id	= $filter->get('id', 'INT', 'GET');
    
    $db	= VF::factory('database');
    $db->prepare('
  		SELECT user_id
  		FROM #__video
  		WHERE video_id = ?
  		AND status = 1
  		LIMIT 1',
  		'i',
  		$video_id
  	);
  	
  	if (!$db->num_rows()) {
  		return;
  	}
    
    $user_id	= $db->fetch_field('user_id');
    
    $db->prepare('
  		SELECT '.implode(',', VData::get('columns', 'video')).'
  		FROM #__video AS v
  		LEFT JOIN #__channel AS ch ON (ch.channel_id = v.channel_id AND ch.status = 1)
        LEFT JOIN #__user AS u ON (u.user_id = v.user_id AND u.status = 1)
        WHERE v.user_id = ?
        AND v.video_id != ?
        AND v.status = 1
        ORDER BY v.add_time DESC
        LIMIT '.VCfg::get('video.view_per_page'),
        'ii',
        array($user_id, $video_id)
    );
    
    if (!$videos = $db->fetch_rows()) {
  		return '<div class="none">'.__('no-user-videos').'</div>';
    }
    
    $code		= array();
    $ids		= array();  
	$vpreview 	= VCfg::get('video.thumb_video') ? ' video-preview' : '';
	$tpreview 	= (!$vpreview && VCfg::get('video.thumb_preview')) ? ' thumb-preview' : '';

    $code[]		= '<ul class="videos">';    
    foreach ($videos as $video) {
  		$ids[]		= $video['video_id'];
  		$percent	= ($video['likes'] > 0 && $video['rated_by']) ? round($video['likes']*100/$video['rated_by']) : 100;
  		$class		= ($percent >= 50) ? 'up' : 'down';
  		$data     	= ' data-id="'.$video['video_id'].'" data-thumb="'.$video['thumb'].'" data-thumbs="'.$video['thumbs'].'"';  		
  		$hd			= ($video['hd']) ? '<strong>'.__('hd').'</strong> ' : '';
  		$views		= ($video['total_views'] == '1') ? __('view') : __('views');
  		$private	= ($video['type'] == '1') ? ' video-private' : '';
  		
  		$code[]		= '<li id="video-'.$video['video_id'].'" class="video'.$private.'">';
  		$code[]		= '<a href="'.video_view_url($video['video_id'], $video['slug']).'" title="'.e($video['title']).'" class="image">';
  		$code[]		= '<div class="video-thumb'.$vpreview.$tpreview.'">';
  		$code[]		= '<img src="'.THUMB_URL.'/'.path($video['video_id']).'/'.$video['thumb'].'.jpg" alt="'.e($video['title']).'" id="preview-'.$video['video_id'].'-user"'.$data.'>';
  		$code[]		= '<span class="duration">'.$hd.VDate::duration($video['duration']).'</span>';
  		
  		if ($private) {
  			$code[]	= '<div class="private-overlay"><i class="fa fa-lock fa-5x"></i><br><strong>'.__('private').'</strong></div>';
  		}
  		
  		$code[]		= '</div></a>';
		$code[]		= '<span class="title"><a href="">'.e($video['title']).'</a></span>';
		$code[]		= '<span class="views">'.$video['total_views'].' '.$views.'</span>';
		$code[]		= '<span class="rating '.$class.'"><i class="fa fa-thumbs-'.$class.'"></i> '.$percent.'%</span>';
		$code[]		= '</li>';
	}
	$code[]		= '</ul>';
	$code[]		= '<div class="clearfix"></div>';
	
	if (VCfg::get('video.ctr')) {
  		$db->query('
      		UPDATE #__video_loads
      		SET total_loads = total_loads+1,
          		today_loads = today_loads+1
      		WHERE video_id IN ('.implode(',', $ids).')
      		LIMIT '.count($ids)
      	);
    }

	return implode('', $code);
}
