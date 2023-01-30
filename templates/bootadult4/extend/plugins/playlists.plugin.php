<?php
function template_plugin_playlists($playlists, $id = null, $colmenu = false, $submenu = false)
{
	$lazy           = VCfg::get('template.bootadult4.lazy');
	$loggedin		= VAuth::loggedin();
	$user_id		= ($loggedin) ? (int) VSession::get('user_id') : 0;
	$ids			= array();
	$output			= array('<div class="grid mx-auto playlists">');
	
	foreach ($playlists as $playlist) {
		$playlist_id	= $playlist['playlist_id'];
		$cache 			= ($playlist['thumb_time']) ? '?t='.$playlist['thumb_time'] : '';
		$thumb 			= ($playlist['thumb_url']) ? $playlist['thumb_url'] : THUMB_URL.'/'.path($playlist['thumb_id']).'/'.$playlist['thumb'].'.jpg'.$cache;
		$ids[]			= $playlist_id;
		$url			= REL_URL.LANG.'/playlist/'.$playlist['playlist_id'].'/'.e($playlist['slug']).'/';
		$name			= e($playlist['name']);
		$thumb 			= ($playlist['thumb_url']) ? $playlist['thumb_url'] : THUMB_URL.'/'.path($playlist['thumb_id']).'/'.$playlist['thumb'].'.jpg'.$cache;
        $data_src   	= ($lazy) ? ' data-src="'.$thumb.'"' : '';
        $thumb      	= ($lazy) ? THUMB_URL.'/loading.gif' : $thumb;
        $lazyc      	= ($lazy) ? ' lazy' : '';		
		
		$output[]	= '<div id="playlist-'.$playlist_id.'" class="cell playlist">';
		$output[]	= '<div class="playlist-thumb">';
		$output[]	= '<a href="'.$url.'" title="'.$name.'"><img src="'.$thumb.'"'.$data_src.' class="thumb'.$lazyc.'" alt="'.__('playlist-thumb', e($playlist['name'])).'" id="preview-'.$playlist_id.$id.'"></a>';
		$output[]	= '<div class="playlist-info playlist-videos"><i class="fa fa-video-camera"></i> '.$playlist['total_videos'].'</div>';
		$output[]	= '<div class="playlist-info playlist-views"><i class="fa fa-eye"></i> '.VText::formatNum($playlist['total_views']).'</div>';
		$output[]	= '</div>';
		$output[]	= '<h5 class="playlist-name"><a href="'.$url.'" title="'.$name.'" data-id="'.$playlist_id.'">'.$name.'</a></h5>';
		
		if ($colmenu) {
			$output[]	= '<div class="text-center mb-3">';
			$output[]	= '<div class="btn-group" role="group" aria-label="">';
			
			if ($submenu == 'user-playlists') {
				$output[]	= '<a href="'.REL_URL.LANG.'/playlist/edit/'.$playlist_id.'/" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> '.__('edit').'</a>';
			}
			
			$output[]	= '<button class="btn btn-sm btn-danger btn-remove" data-id="'.$playlist_id.'" data-sub="'.e($submenu).'"><i class="fa fa-trash"></i> '.__('delete').'</button>';
			$output[]	= '</div></div>';
		}
		
		$output[]	= '</div>';
	}
	
	$output[]	= '</div>';
	
	return implode("\n", $output);
}
