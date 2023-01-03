<?php
function template_widget_channels_viewed()
{
	$cmodel		= VModel::load('channel', 'channel');
	$timeline	= VCfg::get('template.defboot.channels_viewed_timeline');
	$total		= $cmodel->total(orientation(), 'all');
	$pagination = VPagination::get(1, $total, VCfg::get('channel.browse_per_page'));
	$channels   = $cmodel->channels(array(), orientation(), 'all', 'viewed', $timeline, VCfg::get('template.defboot.channels_featured_nr'));
	
	$timeline	= ($timeline != 'all') ? $timeline.'/' : '';
	$timeline	= '';
	$url		= REL_URL.LANG.ORIENTATION.'/channels/viewed/'.$timeline;
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title pull-left"><strong>'.__('trending-channels').'</strong></h3>';
    $output[]   = '<a href="'.$url.'" class="btn btn-menu btn-xs pull-right">'.__('view-more').'</a>';
    $output[]   = '<div class="clearfix"></div>';    
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($channels) {
  		if (!function_exists('display_channels')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/channel.php';
  		}
  		
  		$output[]	= display_channels($channels);
  	} else {
  		$output[]	= '<div class="none">'.__('no-channels').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
    if ($total > 0) {
        $output[]   = '<nav class="text-center"><ul class="pagination">'.p('pagination', $pagination, $url.'#PAGE#/').'</ul></nav>';
    }
  	
  	return implode('', $output);
}
