<?php
function template_plugin_categories($categories, $type = 'video', $absolute = false, $premium = false, $class = 'categories')
{
	$lazy           = VCfg::get('template.bootadult4.lazy');
	$types			= array(
		'video' => MEDIA_REL.'/videos/cat/',
		'photo'	=> MEDIA_REL.'/photos/cat/'
	);
	
	if (!isset($types[$type])) {
		die('Invalid category type!');
	}
	
	$img_url		= $types[$type];
	$ids			= array();
	$output			= array('<div class="grid mx-auto '.$class.'">');
	
	foreach ($categories as $index => $category) {
		$cat_id		= (int) $category['cat_id'];
		$ids[]		= $cat_id;
		$function	= $type.'_category_url';
		$url		= $function($category['slug'], $absolute, $premium);
		$name		= e($category['name']);
		$thumb		= $img_url.$cat_id.'.'.$category['ext'];
        $data_src   = ($lazy) ? ' data-src="'.$thumb.'"' : '';
        $thumb      = ($lazy) ? CHANNEL_URL.'/loading.jpg' : $thumb;
        $lazyc      = ($lazy) ? ' lazy' : '';
		
		$output[]	= '<div id="category-'.$cat_id.'" class="cell category">';
		$output[]	= '<div class="category-thumb">';
		$output[]	= '<a href="'.$url.'" title="'.$name.'"><img src="'.$thumb.'"'.$data_src.' alt="'.$name.'" class="thumb rounded'.$lazyc.'"></a>';
		
		if ($type == 'video') {		
			$output[]	= '<div class="category-info category-videos"><i class="fa fa-video-camera"></i> '.$category['total_videos'].'</div>';
		} elseif ($type == 'photo') {
			$output[]	= '<div class="category-info category-albums"><i class="fa fa-photo-camera"></i> '.$category['total_albums'].'</div>';
		}
		
		$output[]	= '<div class="category-info category-views"><i class="fa fa-eye"></i> '.$category['total_views'].'</div>';
		$output[]	= '</div>';
		$output[]	= '<h5 class="category-name"><a href="'.$url.'" title="'.$name.'">'.$name.'</a></h5>';
		$output[]	= '</div>';
	}	
	
	$output[]		= '</div>';
	
	if (VCfg::get($type.'.category_ctr') and $ids) {
		p('ctr_categories', $ids);
	}
	
	return implode("\n", $output);
}
