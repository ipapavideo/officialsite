<?php
function template_widget_videos_recent()
{
	$vmodel		= VModel::load('video', 'video');
	$total		= $vmodel->total(array('orientation' => orientation()));
	$pagination	= VPagination::get(1, $total, VCfg::get('video.browse_per_page'));
	$videos		= $vmodel->videos(array(
		'orientation'	=> orientation(),
		'order'			=> 'recent'
	), VCfg::get('template.defboot.videos_recent_nr'));
	
  	$url		= (VCfg::get('video.browse_url')) ? REL_URL.LANG.ORIENTATION.'/videos/recent/' : REL_URL.LANG.ORIENTATION.'/recent/';
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title pull-left"><strong>'.__('most-recent-videos').'</strong></h3>';
    $output[]   = '<a href="'.$url.'" class="btn btn-menu btn-xs pull-right">'.__('view-more').'</a>';
    $output[]   = '<div class="clearfix"></div>';    
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($videos) {
  		if (!function_exists('display_videos')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/video.php';
  		}
  		
  		$output[]	= display_videos($videos, 'recent');
  	} else {
  		$output[]	= '<div class="none">'.__('no-videos').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	if ($total > 0) {
  		$output[]	= '<nav class="text-center"><ul class="pagination">'.p('pagination', $pagination, $url.'#PAGE#/').'</ul></nav>';
  	}
  	
  	return implode('', $output);
}