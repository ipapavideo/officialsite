<?php
function template_widget_channels_featured()
{
	$cmodel		= VModel::load('channel', 'channel');
	$channels	= $cmodel->channels(array(), orientation(), 'all', 'featured', 'all', VCfg::get('template.bootadult4.channels_featured_nr'));

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<h2 class="w-100">'.__('featured-channels').'</h2>';

    if ($channels) {
        $output[]   = p('channels', $channels);
    } else {
        $output[]   = '<div class="none">'.__('no-featured-channels').'</div>';
    }

    $output[]   = '</div></div>';

  	return implode('', $output);
}