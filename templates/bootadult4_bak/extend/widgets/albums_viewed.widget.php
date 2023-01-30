<?php
function template_widget_albums_viewed()
{
	$amodel		= VModel::load('album', 'photo');
	$timeline	= VCfg::get('template.bootadult4.albums_viewed_timeline');
	$total		= $amodel->total(array('orientation' => orientation(), 'timeline' => $timeline));
	$pagination	= VPagination::get(1, $total, VCfg::get('photo.browse_per_page'));
	$albums		= $amodel->albums(array(
		'orientation'	=> orientation(),
		'timeline'		=> $timeline,
		'order'			=> 'viewed'
	), VCfg::get('template.bootadult4.albums_viewed_nr'));

	$timeline	= ($timeline != 'all') ? $timeline.'/' : '';
	$url        = (VCfg::get('photo.browse_url')) ? REL_URL.LANG.ORIENTATION.'/photos/viewed/'.$timeline : REL_URL.LANG.ORIENTATION.'/photo/viewed/'.$timeline;	

    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-md-8 text-center text-md-left">';
    $output[]   = '<h2>'.__('trending-photo-albums').'</h2>';
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