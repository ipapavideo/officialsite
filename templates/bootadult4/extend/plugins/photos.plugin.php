<?php
function template_plugin_photos($photos, $album = array(), $id = null, $colmenu = false, $submenu = false)
{
	$lazy			= VCfg::get('template.bootadult4.lazy');
	$del 			= VCfg::get('photo.allow_delete');
	$album_user_id 	= ($album and isset($album['user_id'])) ? $album['user_id'] : 0;
	$ids			= array();
	$output			= array('<div class="grid mx-auto photos">');
	
	foreach ($photos as $photo) {
		$photo_id	= $photo['photo_id'];
		$ids[]		= $photo_id;
		$percent  	= ($photo['percent']) ? round($photo['percent']) : 100;
		$class    	= ($percent >= 50) ? 'up' : 'down';
		$class_text	= ($class == 'up') ? ' text-success' : ' text-danger';
		$private	= ($photo['type'] == '1') ? true : false;
		$premium  	= (isset($photo['premium']) and $photo['premium']) ? true : false;
		$caption	= ($photo['caption']) ? $photo['caption'] : '';
		$url		= REL_URL.LANG.'/photo/'.$photo_id.'/';
		$user_id  	= (isset($photo['user_id']) and $photo['user_id']) ? $photo['user_id'] : $album_user_id;
		$thumb		= PHOTO_THUMB_URL.'/'.$photo_id.'.jpg';
        $data_src   = ($lazy) ? ' data-src="'.$thumb.'"' : '';
        $thumb      = ($lazy) ? PHOTO_THUMB_URL.'/loading.jpg' : $thumb;
        $lazyc      = ($lazy) ? ' lazy' : '';
		
		$output[]	= '<div id="photo-'.$photo_id.'" class="cell photo">';
		$output[]	= '<div class="photo-thumb">';
		$output[]	= '<a href="'.$url.'" title="'.$caption.'"><img src="'.$thumb.'"'.$data_src.' class="thumb rounded'.$lazyc.'" alt="'.__('photo-thumb', $caption).'"></a>';
		$output[]   = '<div class="photo-info photo-rating '.$class.'"><i class="fa fa-thumbs-'.$class.$class_text.'"></i> '.$percent.'%</div>';
		$output[]	= '<div class="photo-info photo-views"><i class="fa fa-eye"></i> '.VText::formatNum($photo['total_views']).'</div>';
		$output[]	= '</div>';
		
		if ($colmenu) {
			$output[]	= '<div class="text-center mt-1 mb-3">';
			$output[]	= '<button class="btn btn-sm btn-danger btn-remove" data-id="'.$photo_id.'" data-sub="'.e($submenu).'"><i class="fa fa-trash"></i> '.__('delete').'</button>';
			$output[]	= '</div>';
		}
		
		$output[]	= '</div>';
	}
	
	$output[]	= '</div>';
	
	if (VCfg::get('photo.ctr') and $ids) {
		p('ctr_photos', $ids);
	}
	
	return implode("\n", $output);
}
