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
	), VCfg::get('template.defboot.videos_featured_nr'));
	
  	$url		= (VCfg::get('video.browse_url')) ? REL_URL.LANG.ORIENTATION.'/videos/featured/' : REL_URL.LANG.ORIENTATION.'/featured/';
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title pull-left"><strong>'.__('featured-videos').'</strong></h3>';
    $output[]   = '<a href="'.$url.'" class="btn btn-menu btn-xs pull-right">'.__('view-more').'</a>';
    $output[]   = '<div class="clearfix"></div>';    
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($videos) {
  		if (!function_exists('display_videos')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/video.php';
  		}
  		
  		$output[]	= display_videos($videos, 'featured');
  	} else {
  		$output[]	= '<div class="none">'.__('no-featured-videos').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	if ($total > 0) {
  		$output[]	= '<nav class="text-center"><ul class="pagination">'.p('pagination', $pagination, $url.'#PAGE#/').'</ul></nav>';
  	}
  	
  	return implode('', $output);
}