<?php
function display_videos($videos, $id = null, $class = null)
{
	$class			= ($class) ? ' '.$class : '';
	$loggedin		= VAuth::loggedin();
	$playlists		= VModule::enabled('playlist');
	$id				= ($id) ? '-'.$id : '';
	$video_preview 	= VCfg::get('video.thumb_video') ? ' video-preview' : '';
	$thumb_preview 	= (!$video_preview && VCfg::get('video.thumb_preview')) ? ' thumb-preview' : '';
	$ids			= array();
	$output			= array();
	$output[]		= '<ul class="videos'.$class.'">';
	
	foreach ($videos as $video) {
		$ids[]		= $video['video_id'];
		$percent  	= ($video['percent']) ? round($video['percent']) : 100;
		$class    	= ($percent >= 50) ? 'up' : 'down';
		$data     	= ' data-id="'.$video['video_id'].'" data-thumb="'.$video['thumb'].'" data-thumbs="'.$video['thumbs'].'"';
		$hd			= ($video['hd']) ? '<strong>'.__('hd').'</strong> ' : '';
		$views		= ($video['total_views'] == '1') ? __('view') : __('views');
		$private	= ($video['type'] == '1') ? ' video-private' : '';
		$preview	= ($video['type'] == '1') ? ' video-private' : $video_preview.$thumb_preview;
        $preview  	= ($video['thumb_url']) ? '' : $preview;
        $cache    	= ($video['thumb_time']) ? '?t='.$video['thumb_time'] : '';
        $thumb    	= ($video['thumb_url']) ? $video['thumb_url'] : THUMB_URL.'/'.path($video['video_id']).'/'.$video['thumb'].'.jpg'.$cache;
		
		$output[]	= '<li id="video-'.$video['video_id'].$id.'" class="video'.$private.'">';
		$output[]	= '<a href="'.video_view_url($video['video_id'], $video['slug']).'" title="'.e($video['title']).'" class="image">';
		$output[]	= '<div class="video-thumb'.$preview.'">';
		$output[]	= '<img src="'.$thumb.'" alt="'.e($video['title']).'" id="preview-'.$video['video_id'].$id.'"'.$data.'>';
		$output[]	= '<span class="duration">'.$hd.VDate::duration($video['duration']).'</span>';
		
		if ($video['type'] == '1') {
			$output[]	= '<div class="private-overlay"><i class="fa fa-lock fa-2x"></i><br>'.__('private').'</div>';
		}
		
		$output[]	= '</div></a>';
		$output[]	= '<span class="title"><a href="'.video_view_url($video['video_id'], $video['slug']).'" title="'.e($video['title']).'">'.e($video['title']).'</a></span>';
		$output[]	= '<span class="views">'.$video['total_views'].' '.$views.'</span>';
		$output[]	= '<span class="rating '.$class.'"><i class="fa fa-thumbs-'.$class.'"></i> '.$percent.'%</span>';
		
		if ($loggedin and $playlists) {
			$output[]	= '<button class="btn btn-icon btn-xs btn-playlist" data-id="'.$video['video_id'].'" type="button" data-toggle="dropdown" aria-expanded="false" style="display: none;"><i class="fa fa-plus"></i></button>';
		}
		
		$output[]	= '</li>';
	}
	
	$output[]	= '</ul>';
	$output[]	= '<div class="clearfix"></div>';
	
	p('ctr_videos', $ids);
	
	return implode("\n", $output);
}
