<?php
function display_albums($albums, $id = null, $class = null)
{
	$id			= ($id) ? '-'.$id : '';
	$ids		= array();
	$class		= ($class) ? ' '.$class : '';
	$loggedin	= VAuth::loggedin();
	
	$output		= array();
	$output[]	= '<ul class="albums'.$class.'">';
	
	foreach ($albums as $album) {
		$ids[]		= $album['album_id'];
		$percent	= ($album['percent']) ? round($album['percent']) : 100;
		$class    	= ($percent >= 50) ? 'up' : 'down';
		$views		= ($album['total_views'] == '1') ? __('view') : __('views');
		
		$output[]	= '<li id="album-'.$album['album_id'].$id.'" class="album">';
		$output[]	= '<a href="'.album_url($album['album_id'], $album['slug']).'" title="'.e($album['title']).'" class="image">';
		$output[]	= '<div class="photo-thumb">';
		$output[]	= '<img src="'.PHOTO_THUMB_URL.'/'.$album['cover_id'].'.jpg" alt="'.__('album-cover', $album['title']).'">';
		$output[]	= '<span class="duration"><i class="fa fa-camera"></i> '.$album['total_photos'].'</span>';
		
		if ($album['type'] == '1') {
			$output[]	= '<div class="private-overlay"><i class="fa fa-lock fa-2x"></i><br>'.__('private').'</div>';
		}
		 
		$output[]	= '</div>';
		$output[]	= '</a>';
		$output[]	= '<span class="title"><a href="'.album_url($album['album_id'], $album['slug']).'" title="'.e($album['title']).'">'.e($album['title']).'</a></span>';
		$output[]	= '<span class="views">'.$album['total_views'].' '.$views.'</span>';
		$output[]	= '<span class="rating '.$class.'"><i class="fa fa-thumbs-'.$class.'"></i> '.$percent.'%</span>';
		$output[]	= '</li>';
	}
	
	$output[]	= '</ul>';
	
	p('ctr_albums', $ids);
	
	return implode('', $output);
}
