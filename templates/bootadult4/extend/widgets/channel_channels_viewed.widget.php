<?php
function template_widget_channel_channels_viewed()
{
    $cmodel     = VModel::load('channel', 'channel');
    $timeline   = VCfg::get('template.bootadult4.channels_viewed_timeline');
    $total      = $cmodel->total(orientation(), 'all');
    $pagination = VPagination::get(1, $total, 5);
    $channels   = $cmodel->channels(array(), orientation(), 'all', 'viewed', $timeline, 5);

    $timeline   = ($timeline != 'all') ? $timeline.'/' : '';
    $timeline   = '';
    $url_all    = REL_URL.LANG.ORIENTATION.'/channels/viewed/'.$timeline;
	
	$output		= array();
	$output[]	= '<div class="d-none d-lg-block">';
	$output[]	= '<hr width="90%">';
	$output[]	= '<div class="w-100 font-weight-bold text-muted mb-2">'.__('viewed').' '.__('channels').'</div>';
	$output[]	= '<ul class="list-unstyled">';
	
	foreach ($channels as $channel) {
        $channel_id 	= $channel['channel_id'];
        $url        	= REL_URL.LANG.'/channel/'.e($channel['slug']).'/';
        $name      	 	= e($channel['name']);
        $arrow      	= 'up';
        $color      	= ' text-success';

        if ($channel['rank_prev'] > $channel['rank']) {
            $arrow  = 'down';
            $color  = ' text-danger';
        }
	
		$output[]	= '<li class="media mb-3">';
		$output[]	= '<a href="'.$url.'" title="'.$name.'"><img src="'.CHANNEL_URL.'/'.$channel['channel_id'].'.logo.'.$channel['logo'].'" alt="'.__('channel-avatar', $name).'" class="rounded mr-2" width="50"></a>';
		$output[]	= '<div class="media-body">';
		$output[]	= '<h6 class="mb-0"><a href="'.$url.'" title="'.$name.'">'.$name.'</a></h6>';
		$output[]	= '<small class="text-muted d-block">'.__('rank').': <strong>'.$channel['rank'].'</strong> <i class="fa fa-arrow-'.$arrow.$color.'"></i></small>';
		$output[]	= '<small class="text-muted d-block">'.__('videos').': <strong>'.VText::formatNum($channel['total_videos']).'</strong></small>';
//		$output[]	= '<small class="text-muted d-block">'.__('viewed').': <strong>'.VText::formatNum($channel['total_views']).'</strong></small>';
		$output[]	= '</div>';
		$output[]	= '</li>';
	}
	
	$output[]	= '</ul>';
	$output[]	= '<div class="text-center"><a href="'.$url_all.'" class="btn btn-sm btn-primary rounded-pill">'.__('view-all').'</a></div>';
	$output[]	= '</div>';
	
	return implode("\n", $output);
}
