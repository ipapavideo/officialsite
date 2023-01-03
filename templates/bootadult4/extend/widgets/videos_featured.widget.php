<?php
function template_widget_videos_featured()
{
	$vmodel		= VModel::load('video', 'video');
	$total		= $vmodel->total(array('orientation' => orientation(), 'featured' => 1));
	$pagination	= VPagination::get(1, $total, VCfg::get('video.browse_per_page'));
	$videos		= $vmodel->videos(array(
		'orientation'	=> orientation(),
		'featured'		=> 1,
		'order'			=> 'featured'
	), VCfg::get('template.bootadult4.videos_featured_nr'));
	
  	$url		= (VCfg::get('video.browse_url')) ? REL_URL.LANG.ORIENTATION.'/videos/featured/' : REL_URL.LANG.ORIENTATION.'/featured/';

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-md-8 text-center text-md-left">';
    $output[]   = '<h2>'.__('featured-videos').'</h2>';
    $output[]   = '</div>';
    $output[]   = '<div class="col-md-4 d-flex justify-content-center justify-content-lg-end align-items-center">';
    $output[]   = '<a href="'.$url.'" class="btn btn-sm btn-light"><i class="fa fa-plus"></i> '.__('view-more').'</a>';
    $output[]   = '</div>';
    $output[]   = '</div>';

    if ($videos) {
        $output[]   = p('videos', $videos);
    } else {
        $output[]   = '<div class="none">'.__('no-videos').'</div>';
    }

    if ($total > 0) {
        $output[]   = '<nav><ul class="pagination pagination-lg justify-content-center">'.p('pagination', $pagination, $url.'#PAGE#/').'</ul></nav>';
    }

    $output[]   = '</div></div>';
  	
  	return implode('', $output);
}
