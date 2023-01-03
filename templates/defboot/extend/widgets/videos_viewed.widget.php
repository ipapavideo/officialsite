<?php
function template_widget_videos_viewed()
{
	$vmodel		= VModel::load('video', 'video');
	$timeline	= VCfg::get('template.defboot.videos_viewed_timeline');
	$total		= $vmodel->total(array('orientation' => orientation(), 'timeline' => $timeline));
	$pagination	= VPagination::get(1, $total, VCfg::get('video.browse_per_page'));
	$videos		= $vmodel->videos(array(
		'orientation'	=> orientation(),
		'timeline'		=> $timeline,
		'order'			=> 'viewed'
	), VCfg::get('template.defboot.videos_viewed_nr'));
	
	$timeline	= ($timeline != 'all') ? $timeline.'/' : '';
  	$url		= (VCfg::get('video.browse_url')) ? REL_URL.LANG.ORIENTATION.'/videos/viewed/'.$timeline : REL_URL.LANG.ORIENTATION.'/viewed/'.$timeline;
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title pull-left"><strong>'.__('trending-videos').'</strong></h3>';
    $output[]   = '<a href="'.$url.'" class="btn btn-menu btn-xs pull-right">'.__('view-more').'</a>';
    $output[]   = '<div class="clearfix"></div>';    
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($videos) {
  		if (!function_exists('display_videos')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/video.php';
  		}
  		
  		$output[]	= display_videos($videos, 'viewed');
  	} else {
  		$output[]	= '<div class="none">'.__('no-videos').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	if ($total > 0) {
  		$output[]	= '<nav class="text-center"><ul class="pagination">'.p('pagination', $pagination, $url.'#PAGE#/').'</ul></nav>';
  	}
  	
  	return implode('', $output);
}