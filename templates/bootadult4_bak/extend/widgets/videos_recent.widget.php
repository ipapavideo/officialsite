<?php
function template_widget_videos_recent()
{
	$vmodel		= VModel::load('video', 'video');
	$total		= $vmodel->total(array('orientation' => orientation()));
	$pagination	= VPagination::get(1, $total, VCfg::get('video.browse_per_page'));
	$videos		= $vmodel->videos(array(
		'orientation'	=> orientation(),
		'order'			=> 'recent'
	), VCfg::get('template.bootadult4.videos_recent_nr'));
	
  	$url		= (VCfg::get('video.browse_url')) ? REL_URL.LANG.ORIENTATION.'/videos/recent/' : REL_URL.LANG.ORIENTATION.'/recent/';

	$output		= array();
	$output[]	= '<div class="row">';
	$output[]	= '<div class="col-lg-12">';
	$output[]	= '<div class="row">';
    $output[]	= '<div class="col-md-8 text-center text-md-left">';
    $output[]	= '<h2>'.__('most-recent-videos').'</h2>';
    $output[]	= '</div>';
    $output[]	= '<div class="col-md-4 d-flex justify-content-center justify-content-lg-end align-items-center">';
    $output[]	= '<a href="'.$url.'" class="btn btn-light btn-sm"><i class="fa fa-plus"></i> '.__('view-more').'</a>';
    $output[]	= '</div>';
    $output[]	= '</div>';
    
    if ($videos) {
		$output[]	= p('videos', $videos);
	} else {
		$output[]	= '<div class="none">'.__('no-videos').'</div>';
	}
	
	if ($total > 0) {
  		$output[]	= '<nav><ul class="pagination pagination-lg justify-content-center">'.p('pagination', $pagination, $url.'#PAGE#/').'</ul></nav>';		
	}
	
	$output[]	= '</div>';
	$output[]	= '</div>';
  	
  	return implode('', $output);
}
