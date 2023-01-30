<?php
function template_plugin_videos($videos, $id = null, $colmenu = false, $submenu = false, $nolazy = false, $noactions = false, $class = 'videos')
{
	$hd				= __('hd');
	$lazy			= (VCfg::get('template.bootadult4.lazy') and !$nolazy) ? true : false;
	$loggedin		= VAuth::loggedin();
	$user_id		= ($loggedin) ? (int) VSession::get('user_id') : 0;
	$playlist		= VModule::enabled('playlist');
	$video_preview 	= VCfg::get('video.thumb_video') ? ' video-preview' : '';
	$thumb_preview 	= (!$video_preview && VCfg::get('video.thumb_preview')) ? ' thumb-preview' : '';
	$ids			= array();
	$output			= array('<div class="grid mx-auto '.$class.'">');
	
	foreach ($videos as $video) {
		$video_id	= $video['video_id'];
		$ids[]		= $video_id;
		$percent  	= ($video['percent']) ? round($video['percent']) : 100;
		$class    	= ($percent >= 50) ? 'up' : 'down';
		$class_text	= ($class == 'up') ? ' text-success' : ' text-danger';
		$private	= ($video['type'] == '1') ? true : false;
		$premium  	= (isset($video['premium']) and $video['premium']) ? true : false;
		$preview  	= ($video['thumb_url'] or $private) ? '' : $video_preview.$thumb_preview;
		$cache    	= ($video['thumb_time']) ? '?t='.$video['thumb_time'] : '';
		$thumb    	= ($video['thumb_url']) ? $video['thumb_url'] : THUMB_URL.'/'.path($video_id).'/'.$video['thumb'].'.jpg'.$cache;
		$thumb		= ($private) ? THUMB_URL.'/private.jpg' : $thumb;
		$data     	= ($private) ? '' : ' data-id="'.$video_id.'" data-thumb="'.$video['thumb'].'" data-thumbs="'.$video['thumbs'].'"';
		$data_src	= ($lazy and !$private) ? ' data-src="'.$thumb.'"' : '';
		$thumb		= ($lazy and !$private) ? THUMB_URL.'/loading.gif' : $thumb;
		$lazyc		= ($lazy and !$private) ? ' lazy' : '';
		$title		= e($video['title']);
		$url		= video_view_url($video_id, $video['slug'], null, $video['premium'], false);
		
		$output[]	= '<div id="video-'.$video_id.'" class="cell video">';
		$output[]	= '<div class="video-thumb'.$preview.'" data-id="'.$video_id.'">';
		$output[]	= '<a href="'.$url.'" title="'.$title.'"><img src="'.$thumb.'"'.$data_src.' class="thumb rounded'.$lazyc.'" alt="'.$title.'" id="preview-'.$video_id.$id.'"'.$data.'></a>';
		
		if ($loggedin and !$noactions) {
		  $output[]	= '<div class="video-actions">';
		  
		  if ($playlist) {
			  $output[]	= '<a href="#add-to-playlist" class="d-inline btn-xs btn-playlist" data-id="'.$video_id.'"><i class="fa fa-plus"></i></a>';
		  }
		  
		  if ($user_id != $video['user_id']) {
			  $output[]	= '<a href="#add-to-favorites" class="d-inline btn-xs video-favorite" data-id="'.$video_id.'"><i class="fa fa-heart"></i></a>';
		  }
		  
		  $output[]	= '</div>';
		}
		
		$output[]	= '<div class="video-info video-rating '.$class.'"><i class="fa fa-thumbs-'.$class.$class_text.'"></i> '.$percent.'%</div>';
		$output[]	= '<div class="video-info video-duration"><i class="fa fa-clock-o"></i> '.VDate::duration($video['duration']).'</div>';
		$output[]	= '<div class="video-info video-views"><i class="fa fa-eye"></i> '.VText::formatNum($video['total_views']).'</div>';
		$output[]	= '</div>';
		$output[]	= '<div class="video-caption">';
		$output[]	= '<h5 class="video-title"><a href="'.$url.'" title="'.$title.'" data-id="'.$video_id.'">'.$title.'</a></h5>';
		
		if ($colmenu) {
			$output[]	= '<div class="text-center mb-3">';
			$output[]	= '<div class="btn-group" role="group" aria-label="">';
			
			if ($submenu == 'user-videos') {
				$output[]	= '<a href="'.video_url().'/edit/'.$video_id.'/" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> '.__('edit').'</a>';
			}
			
			$output[]	= '<button class="btn btn-sm btn-danger btn-remove" data-id="'.$video_id.'" data-sub="'.e($submenu).'"><i class="fa fa-trash"></i> '.__('delete').'</button>';
			$output[]	= '</div></div>';
		}
		
		$output[]	= '</div>';
		$output[]	= '</div>';
	}
	
	$output[]	= '</div>';
	
	if (VCfg::get('video.ctr') and $ids) {
		p('ctr_videos', $ids);
	}
	
	return implode("\n", $output);
}
