<?php
function ajax_plugin_video_related()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger', 'page' => 0, 'end' => 0);
	
	if (!isset($_POST['video_id']) or !isset($_POST['page'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}
	
	
    VLanguage::load('frontend.video');

    $filter		= VF::factory('filter');
    $video_id	= $filter->get('video_id', 'INT');
    $page		= $filter->get('page', 'INT');

	$vmodel		= VModel::load('video', 'video');
	if (!$video = $vmodel->related($video_id)) {
		$data['msg']	= 'Invalid video!';
		return json_encode($data);
	}
	
	$perpage	= VCfg::get('video.view_per_page');
	$rmodel		= VModel::load('related', 'video');
	$related	= $rmodel->related($video_id, $video['orientation'], $video['title'], $video['tags'], $video['categories'], $page, $perpage);
	$total		= $related['total'];
	$videos		= $related['videos'];
    
    $code		= array();
    $ids		= array();  
	$vpreview 	= VCfg::get('video.thumb_video') ? ' video-preview' : '';
	$tpreview 	= (!$vpreview && VCfg::get('video.thumb_preview')) ? ' thumb-preview' : '';

    foreach ($videos as $video) {
  		$ids[]		= $video['video_id'];
  		$percent	= ($video['likes'] > 0 && $video['rated_by']) ? round($video['likes']*100/$video['rated_by']) : 100;
  		$class		= ($percent >= 50) ? 'up' : 'down';
  		$vdata     	= ' data-id="'.$video['video_id'].'" data-thumb="'.$video['thumb'].'" data-thumbs="'.$video['thumbs'].'"';  		
  		$hd			= ($video['hd']) ? '<strong>'.__('hd').'</strong> ' : '';
  		$views		= ($video['total_views'] == '1') ? __('view') : __('views');
  		$private	= ($video['type'] == '1') ? ' video-private' : '';
  		
  		$code[]		= '<li id="video-'.$video['video_id'].'" class="video'.$private.'">';
  		$code[]		= '<a href="'.video_view_url($video['video_id'], $video['slug']).'" title="'.e($video['title']).'" class="image">';
  		$code[]		= '<div class="video-thumb'.$vpreview.$tpreview.'">';
  		$code[]		= '<img src="'.THUMB_URL.'/'.path($video['video_id']).'/'.$video['thumb'].'.jpg" alt="'.e($video['title']).'" id="preview-'.$video['video_id'].'-user"'.$vdata.'>';
  		$code[]		= '<span class="duration">'.$hd.VDate::duration($video['duration']).'</span>';
  		
    	if ($private) {
            $code[] = '<div class="private-overlay"><i class="fa fa-lock fa-5x"></i><br><strong>'.__('private').'</strong></div>';
        }  		
  		
  		$code[]		= '</div></a>';
		$code[]		= '<span class="title"><a href="">'.e($video['title']).'</a></span>';
		$code[]		= '<span class="views">'.$video['total_views'].' '.$views.'</span>';
		$code[]		= '<span class="rating '.$class.'"><i class="fa fa-thumbs-'.$class.'"></i> '.$percent.'%</span>';
		$code[]		= '</li>';
	}
	
	if ($ids && VCfg::get('video.ctr')) {
  		VF::factory('database')->query('
      		UPDATE #__video_loads
      		SET total_loads = total_loads+1,
          		today_loads = today_loads+1
      		WHERE video_id IN ('.implode(',', $ids).')
      		LIMIT '.count($ids)
      	);
    }

	$data['status']	= 1;
	$data['code']	= implode('', $code);
	$data['page']	= $page+1;

	if ($total <= $perpage*$page) {
		$data['end']	= 1;
	}
	
	return json_encode($data);
}
