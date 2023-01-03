<?php
function template_widget_videos_viewed()
{
	$vmodel		= VModel::load('video', 'video');
	$timeline	= VCfg::get('template.bootadult4.videos_viewed_timeline');
	$total		= $vmodel->total(array('orientation' => orientation(), 'timeline' => $timeline));
	$pagination	= VPagination::get(1, $total, VCfg::get('video.browse_per_page'));
	$videos		= $vmodel->videos(array(
		'orientation'	=> orientation(),
		'timeline'		=> $timeline,
		'order'			=> 'viewed'
	), VCfg::get('template.bootadult4.videos_viewed_nr'));
	
	$timeline	= ($timeline != 'all') ? $timeline.'/' : '';
  	$url		= (VCfg::get('video.browse_url')) ? REL_URL.LANG.ORIENTATION.'/videos/viewed/'.$timeline : REL_URL.LANG.ORIENTATION.'/viewed/'.$timeline;

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-md-8 text-center text-md-left">';
    $output[]   = '<h2>'.__('trending-videos').'</h2>';
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

    $output[]   = '</div>';
    $output[]   = '</div>';
  	
  	return implode('', $output);
}
