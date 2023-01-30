<?php
function template_widget_channels_viewed()
{
	$cmodel		= VModel::load('channel', 'channel');
	$timeline	= VCfg::get('template.bootadult4.channels_viewed_timeline');
	$total		= $cmodel->total(orientation(), 'all');
	$pagination = VPagination::get(1, $total, VCfg::get('channel.browse_per_page'));
	$channels   = $cmodel->channels(array(), orientation(), 'all', 'viewed', $timeline, VCfg::get('template.bootadult4.channels_featured_nr'));
	
	$timeline	= ($timeline != 'all') ? $timeline.'/' : '';
	$timeline	= '';
	$url		= REL_URL.LANG.ORIENTATION.'/channels/viewed/'.$timeline;

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-md-8 text-center text-md-left">';
    $output[]   = '<h2>'.__('trending-channels').'</h2>';
    $output[]   = '</div>';
    $output[]   = '<div class="col-md-4 d-flex justify-content-center justify-content-lg-end align-items-center">';
    $output[]   = '<a href="'.$url.'" class="btn btn-light btn-sm"><i class="fa fa-plus"></i> '.__('view-more').'</a>';
    $output[]   = '</div></div>';

    if ($channels) {
        $output[]   = p('channels', $channels);
    } else {
        $output[]   = '<div class="none">'.__('no-channels').'</div>';
    }

    $output[]   = '</div></div>';
  	
  	return implode('', $output);
}
