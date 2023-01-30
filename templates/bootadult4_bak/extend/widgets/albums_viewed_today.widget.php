<?php
function template_widget_albums_viewed_today()
{
	$amodel		= VModel::load('album', 'photo');
	$timeline	= 'today';
	$albums		= $amodel->albums(array(
		'orientation'	=> orientation(),
		'timeline'		=> $timeline,
		'order'			=> 'viewed'
	), 15);
	
	if (!$albums) {
		return;
	}
	
	VLanguage::load('frontend.frontpage');

    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<h2>'.__('trending-photo-albums').'</h2>';
    $output[]   = p('albums', $albums);
    $output[]   = '</div>';
    $output[]   = '</div>';  	
  	
  	return implode('', $output);
}
