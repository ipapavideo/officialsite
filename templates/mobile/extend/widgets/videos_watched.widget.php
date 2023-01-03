<?php
function template_widget_videos_watched()
{
	$vmodel	= VModel::load('video', 'video');
	$videos	= $vmodel->videos(array(
		'orientation'	=> orientation(),
		'timeline'		=> 'all',
		'order'			=> 'watched'
	), VCfg::get('template.defboot.videos_watched_nr'));
	
	$url		= (VCfg::get('video.browse_url')) ? REL_URL.LANG.ORIENTATION.'/videos/watched/' : REL_URL.LANG.ORIENTATION.'/watched/';
	
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title pull-left"><strong>'.__('watched-videos').'</strong></h3>';
    $output[]	= '<a href="'.$url.'" class="btn btn-menu btn-xs pull-right">'.__('view-more').'</a>';
    $output[]	= '<div class="clearfix"></div>';
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($videos) {
  		if (!function_exists('display_videos')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/video.php';
  		}
  		
  		$output[]	= p('adv_square', 'frontpage-video-watched');
  		$output[]	= display_videos($videos, 'watched', 'videosw');
  	} else {
  		$output[]	= '<div class="none">'.__('no-videos').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	return implode('', $output);
}
