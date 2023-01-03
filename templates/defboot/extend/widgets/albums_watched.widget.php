<?php
function template_widget_albums_watched()
{
	$amodel	= VModel::load('album', 'photo');
	$albums	= $amodel->albums(array(
		'orientation'	=> orientation(),
		'timeline'		=> 'all',
		'order'			=> 'watched'
	), VCfg::get('template.defboot.albums_watched_nr'));
	
	$url    	= (VCfg::get('photo.browse_url')) ? REL_URL.LANG.ORIENTATION.'/photos/watched/' : REL_URL.LANG.ORIENTATION.'/photo/watched/';
	
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title pull-left"><strong>'.__('watched-photo-albums').'</strong></h3>';
    $output[]	= '<a href="'.$url.'" class="btn btn-menu btn-xs pull-right">'.__('view-more').'</a>';
    $output[]	= '<div class="clearfix"></div>';
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($albums) {
  		if (!function_exists('display_albums')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/photo.php';
  		}
  		
  		$output[]	= display_albums($albums, 'watched');
  	} else {
  		$output[]	= '<div class="none">'.__('no-albums').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	return implode('', $output);
}