<?php
function template_plugin_categories($current, $type = 'video', $categories = array(), $query = null)
{
    $types      	= array('video' => 1, 'photo' => 1, 'game' => 1, 'article' => 1, 'video-premium' => 1);
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
    
//    echo VF::debug($categories);    
    
    $output		= array();
    $ids		= array();
    $output[]	= '<ul class="nav nav-stacked nav-list">';
  	$all		= ($current == 'all' or !$current) ? ' class="active"' : '';
  	$function	= $type.'_category_url';
  	$url		= ($query) ? REL_URL.LANG.'/search/'.$type.'/?s='.e(str_replace(' ', '+', $query)) : $function('all', false, $premium);
  	$output[]	= '<li'.$all.'><a href="'.str_replace('all/', '', $url).'">'.__('all').'</a></li>';
    
    foreach ($categories as $category) {
  		$cat_id			= $category['cat_id'];
    
  		if (!isset($ids[$cat_id])) {
  			$ids[$cat_id]	= 1;
  			$active			= ($cat_id == $current) ? ' class="active"' : '';
  			$url			= ($query) ? REL_URL.LANG.'/search/'.$type.'/?s='.e(str_replace(' ', '+', $query)).'&c='.$cat_id : $function($category['slug']);
  			$output[]		= '<li'.$active.'><a href="'.$url.'">'.e($category['name']).'</a></li>';
  		}
  		
  		if (isset($category['sub_cat_id']) and $sub_cat_id = $category['sub_cat_id']) {
  			if (!isset($ids[$sub_cat_id])) {
  				$ids[$sub_cat_id]	= 1;
  				$active				= ($sub_cat_id == $current) ? ' class="active"' : '';
  				$url				= ($query) ? REL_URL.LANG.'/search/'.$type.'/?s='.e(str_replace(' ', '+', $query)).'&c='.$sub_cat_id : $function($category['sub_slug']);
  				$output[]			= '<li'.$active.'><a href="'.$url.'">&nbsp; '.e($category['sub_name']).'</a></li>';
  			}
  		}
    }
    
    $output[]	= '</ul>';
    
    if (VCfg::get($type.'.category_ctr') && $ids) {
  		VF::factory('database')->query('
  			UPDATE #__'.$type.'_categories_loads
  			SET total_loads = total_loads+1,
  			    today_loads = today_loads+1  			
  			WHERE cat_id IN ('.implode(',', $ids).')
  			LIMIT '.count($ids)
  		);
    }
	
	return implode('', $output);
}
