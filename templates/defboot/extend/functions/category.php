<?php
function display_categories($categories, $id = null, $class = null)
{
	$id			= ($id) ? '-'.$id : '';
	$ids		= array();
	$class		= ($class) ? ' '.$class : '';
	
	$output		= array();
	$output[]	= '<ul class="categories'.$class.'">';
	
	foreach ($categories as $category) {
		$category_id	= $category['cat_id'];
		$ids[]			= $category_id;
		
		$output[]		= '<li id="video-category-'.$category_id.'" class="category">';
		$output[]		= '<a href="'.video_category_url($category['slug']).'" title="'.e($category['name']).'">';
		$output[]		= '<div class="category-thumb">';
		$output[]		= '<img src="'.MEDIA_REL.'/videos/cat/'.$category_id.'.'.$category['ext'].'" alt="'.__('category-image', e($category['name'])).'">';
		$output[]		= '<div class="category-videos"><i class="fa fa-video-camera"></i> '.$category['total_videos'].'</div>';
		$output[]		= '</div>';
		$output[]		= '</a>';
		$output[]		= '<span class="category-title"><a href="'.video_category_url($category['slug']).'" title="'.e($category['name']).'">'.e($category['name']).'</a></span>';
		$output[]		= '</li>';
	}
	
	$output[]	= '</ul>';
	
	p('ctr_categories', $ids);
	
	return implode('', $output);
}
