<?php
function template_widget_categories_all()
{
	$cmodel		= VModel::load('category', 'video');
	$categories	= $cmodel->categories(orientation());

	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title"><strong>'.__('all-categories').'</strong></h3>';
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($categories) {
  		$output[]	= '<ul class="nav nav-stacked nav-list columns">';

  		foreach ($categories as $category) {
  			$ids[]			= $category['cat_id'];
  			$output[]		= '<li><a href="'.video_category_url($category['slug']).'">'.e($category['name']).'<span class="pull-right"><strong>'.$category['total_videos'].'</strong></span></a></li>';
  		}
  		
  		$output[]	= '</ul>';
  	} else {
  		$output[]	= '<div class="none">'.__('no-categories').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	return implode('', $output);
}
