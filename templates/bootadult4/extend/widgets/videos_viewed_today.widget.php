<?php
function template_widget_videos_viewed_today()
{
	$vmodel		= VModel::load('video', 'video');
	$videos		= $vmodel->videos(array(
		'orientation'	=> orientation(),
		'timeline'		=> 'today',
		'order'			=> 'viewed'
	), 15);
	
	if (!$videos) {
		return;
	}
	
	VLanguage::load('frontend.frontpage');
	
    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<h2>'.__('trending-videos').'</h2>';
    $output[]   = p('videos', $videos);
    $output[]   = '</div>';
    $output[]   = '</div>';
  	
  	return implode('', $output);
}
