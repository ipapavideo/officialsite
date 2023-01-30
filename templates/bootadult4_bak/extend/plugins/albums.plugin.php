<?php
function template_plugin_albums($albums, $id = null, $colmenu = false, $submenu = false, $class = 'albums')
{
	$lazy           = VCfg::get('template.bootadult4.lazy');
	$loggedin		= VAuth::loggedin();
	$ids			= array();
	$output			= array('<div class="grid mx-auto '.$class.'">');
	
	foreach ($albums as $album) {
		$album_id	= $album['album_id'];
		$ids[]		= $album_id;
		$percent  	= ($album['percent']) ? round($album['percent']) : 100;
		$class    	= ($percent >= 50) ? 'up' : 'down';
		$class_text	= ($class == 'up') ? ' text-success' : ' text-danger';
		$private	= ($album['type'] == '1') ? true : false;
		$premium  	= (isset($album['premium']) and $album['premium']) ? true : false;
		$title		= e($album['title']);
		$url		= album_url($album_id, $album['slug'], $album['premium'], false);
		$thumb		= PHOTO_THUMB_URL.'/'.$album['cover_id'].'.jpg';
		$data_src	= ($lazy) ? ' data-src="'.$thumb.'"' : '';
		$thumb		= ($lazy) ? PHOTO_THUMB_URL.'/loading.jpg' : $thumb;
		$lazyc		= ($lazy) ? ' lazy' : '';
		
		$output[]	= '<div id="album-'.$album_id.'" class="cell album">';
		$output[]	= '<div class="photo-thumb">';
		$output[]	= '<a href="'.$url.'" title="'.$title.'"><img src="'.$thumb.'"'.$data_src.' class="thumb rounded'.$lazyc.'" alt="'.__('album-cover', $album['title']).'"></a>';
		$output[]   = '<div class="album-info album-rating '.$class.'"><i class="fa fa-thumbs-'.$class.$class_text.'"></i> '.$percent.'%</div>';
		$output[]	= '<div class="album-info album-photos"><i class="fa fa-camera"></i> '.$album['total_photos'].'</div>';
		$output[]	= '<div class="album-info album-views"><i class="fa fa-eye"></i> '.VText::formatNum($album['total_views']).'</div>';
		$output[]	= '</div>';
		$output[]	= '<h5 class="album-title"><a href="'.$url.'" title="'.$title.'">'.$title.'</a></h5>';
		
		if ($colmenu) {
			$output[]	= '<div class="text-center mb-3">';
			$output[]	= '<div class="btn-group" role="group" aria-label="">';
			
			if ($submenu == 'user-albums') {
				$output[]	= '<a href="'.REL_URL.LANG.'/photo/edit/'.$album['album_id'].'/" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> '.__('edit').'</a>';
			}
			
			$output[]	= '<button class="btn btn-sm btn-danger btn-remove" data-id="'.$album['album_id'].'" data-sub="'.e($submenu).'"><i class="fa fa-trash"></i> '.__('delete').'</button>';
			$output[]	= '</div></div>';
		}
		
		$output[]	= '</div>';
	}
	
	$output[]	= '</div>';
	
	if (VCfg::get('photo.ctr') and $ids) {
		p('ctr_albums', $ids);
	}
	
	return implode("\n", $output);
}
