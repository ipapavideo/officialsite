<?php
function template_widget_channels_ranked()
{
	$cmodel		= VModel::load('channel', 'channel');
	$channels	= $cmodel->channels(array(), orientation(), 'all', 'popular', 'all', VCfg::get('template.bootadult4.channels_ranked_nr'));

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-md-8 text-center text-md-left">';
    $output[]   = '<h2>'.__('popular-channels').'</h2>';
    $output[]   = '</div>';
    $output[]   = '<div class="col-md-4 d-flex justify-content-center justify-content-lg-end align-items-center>';
    $output[]   = '<a href="'.REL_URL.LANG.'/channels/popular/" class="btn btn-light btn-sm"><i class="fa fa-plus"></i> '.__('view-more').'</a>';
    $output[]   = '</div></div>';
    
    if ($channels) {
        $output[]   = p('channels', $channels);
    } else {
        $output[]   = '<div class="none">'.__('no-channels').'</div>';
    }

    $output[]   = '</div></div>';

  	return implode('', $output);
}
