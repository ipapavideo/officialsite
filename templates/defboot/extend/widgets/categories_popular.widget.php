<?php
function template_widget_categories_popular()
{
	$cmodel		= VModel::load('category', 'video');
	$categories	= $cmodel->categories(orientation(), 'popular', VCfg::get('template.defboot.categories_popular_nr'));

	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title pull-left"><strong>'.__('popular-categories').'</strong></h3>';
    $output[]	= '<a href="'.REL_URL.LANG.'/categories/?order=popular" class="btn btn-menu btn-xs pull-right">'.__('view-more').'</a>';
    $output[]	= '<div class="clearfix"></div>';
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($categories) {
  		if (!function_exists('display_categories')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/category.php';
  		}
  		
  		$output[]	= display_categories($categories, 'popular', 'categoriesf');
  	} else {
  		$output[]	= '<div class="none">'.__('no-categories').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	return implode('', $output);
}
