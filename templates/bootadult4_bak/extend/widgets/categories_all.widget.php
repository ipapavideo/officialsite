<?php
function template_widget_categories_all()
{
	$cmodel		= VModel::load('category', 'video');
	$categories	= $cmodel->categories(orientation());

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<h2>'.__('all-categories').'</h2>';

    if ($categories) {
  		$output[]	= '<ul class="list-unstyled row">';

  		foreach ($categories as $category) {
  			$ids[]			= $category['cat_id'];
  			$output[]		= '<li class="list-item col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2"><a href="'.video_category_url($category['slug']).'">'.e($category['name']).'<span class="pull-right"><strong>'.$category['total_videos'].'</strong></span></a></li>';
  		}
  		
  		$output[]	= '</ul>';
  	} else {
  		$output[]	= '<div class="none none-small">'.__('no-categories').'</div>';
  	}

    $output[]   = '</div>';
    $output[]   = '</div>';

    return implode('', $output);
}
