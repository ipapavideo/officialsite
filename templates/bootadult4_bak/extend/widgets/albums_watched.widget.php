<?php
function template_widget_albums_watched()
{
	$amodel	= VModel::load('album', 'photo');
	$albums	= $amodel->albums(array(
		'orientation'	=> orientation(),
		'timeline'		=> 'all',
		'order'			=> 'watched'
	), VCfg::get('template.bootadult4.albums_watched_nr'));
	
	$url    	= (VCfg::get('photo.browse_url')) ? REL_URL.LANG.ORIENTATION.'/photos/watched/' : REL_URL.LANG.ORIENTATION.'/photo/watched/';

    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-md-8 text-center text-md-left">';
    $output[]   = '<h2>'.__('watched-photo-albums').'</h2>';
    $output[]   = '</div>';
    $output[]   = '<div class="col-md-4 d-flex justify-content-center justify-content-lg-end align-items-center">';
    $output[]   = '<a href="'.$url.'" class="btn btn-sm btn-light">'.__('view-more').'</a>';
    $output[]   = '</div>';
    $output[]   = '</div>';

    if ($albums) {
        $output[]   = p('albums', $albums);
    } else {
        $output[]   = '<div class="none">'.__('no-albums').'</div>';
    }

    $output[]   = '</div>';
    $output[]   = '</div>';

    return implode('', $output);
}
