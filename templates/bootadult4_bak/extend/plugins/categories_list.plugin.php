<?php
function template_plugin_categories_list($current, $type = 'video', $categories = array(), $query = null)
{
    $types      	= array('video' => 'total_videos', 'photo' => 'total_albums', 'game' => 'total_games', 'article' => 'total_articles', 'video-premium' => 'total_videos');
    if (!isset($types[$type])) {
        throw new VException('Invalid categories type!');
    }

    $premium	= false;
    if (strpos($type, '-premium') !== false) {
  		$premium	= true;
  		$type		= str_replace('-premium', '', $type);
    }
	
	$orientation	= orientation();
    if (!$categories) {
        $categories = VModel::load('category', $type)->tree($orientation);
    }
    
    $ids		= array();
    $output		= array();    
  	$function	= $type.'_category_url';
  	$total		= $types[$type];
  	$url		= ($query) ? REL_URL.LANG.'/search/'.$type.'/?s='.e(str_replace(' ', '+', $query)) : $function('all', false, $premium);
    
    foreach ($categories as $category) {
  		$cat_id	= $category['cat_id'];

  		if (!isset($ids[$cat_id])) {
  			$ids[$cat_id]		= 1;
  			$active				= ($cat_id == $current) ? ' active' : '';
  			$url				= ($query) ? REL_URL.LANG.'/search/'.$type.'/?s='.e(str_replace(' ', '+', $query)).'&c='.$cat_id : $function($category['slug']);
  			$output[]			= '<a href="'.$url.'" class="list-group-item list-group-item-action'.$active.'">'.e($category['name']).' <span class="float-right">'.$category[$total].'</span></a>';
  		}

  		if (isset($category['sub_cat_id']) and $sub_cat_id = $category['sub_cat_id']) {
  			if (!isset($ids[$sub_cat_id])) {
  				$ids[$sub_cat_id]	= 1;
  				$active				= ($sub_cat_id == $current) ? ' class="active"' : '';
  				$url				= ($query) ? REL_URL.LANG.'/search/'.$type.'/?s='.e(str_replace(' ', '+', $query)).'&c='.$sub_cat_id : $function($category['sub_slug']);
  				$output[]			= '<a href="'.$url.'" class="list-group-item list-group-item-action subcategory'.$active.'">&nbsp; '.e($category['sub_name']).' <span class="float-right">'.$category[$total].'</span></a>';
  			}
  		}
    }
    
    p('ctr_categories', $ids);
	
	return implode('', $output);
}
