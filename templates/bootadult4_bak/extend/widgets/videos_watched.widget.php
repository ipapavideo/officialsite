<?php
function template_widget_videos_watched()
{
	$vmodel	= VModel::load('video', 'video');
	$videos	= $vmodel->videos(array(
		'orientation'	=> orientation(),
		'timeline'		=> 'all',
		'order'			=> 'watched'
	), VCfg::get('template.bootadult4.videos_watched_nr'));
	
	$url		= (VCfg::get('video.browse_url')) ? REL_URL.LANG.ORIENTATION.'/videos/watched/' : REL_URL.LANG.ORIENTATION.'/watched/';

    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-md-8 text-center text-md-left">';
    $output[]   = '<h2>'.__('watched-videos').'</h2>';
    $output[]   = '</div>';
    $output[]   = '<div class="col-md-4 d-flex justify-content-center justify-content-lg-end align-items-center">';
    $output[]   = '<a href="'.$url.'" class="btn btn-sm btn-light"><i class="fa fa-plus"></i> '.__('view-more').'</a>';
    $output[]   = '</div>';
    $output[]   = '</div>';

    if ($videos) {
  		if ($adv = p('adv', 'frontpage-video-watched')) {
  			$output[]	= '<div class="row">';
  			$output[]	= '<div class="col-12 col-md">';
      		$output[]   = p('videos', $videos, '-watched');
  			$output[]	= '</div>';
  			$output[]	= '<div class="col-12 col-md-auto pl-0 align-self-center">';
  			$output[]	= '<div class="w-310 h-100 content-side m-auto">';
  			$output[]	= '<small class="w-100 text-muted d-flex justify-content-center">'.__('advertising').'</small>';
  			$output[]	= $adv;
  			$output[]	= '</div>';
  			$output[]	= '</div>';
  			$output[]	= '</div>';
  		} else {    
      		$output[]   = p('videos', $videos, '-watched');
      	}
    } else {
        $output[]   = '<div class="none">'.__('no-videos').'</div>';
    }

    $output[]   = '</div>';
    $output[]   = '</div>';	
  	
  	return implode('', $output);
}
