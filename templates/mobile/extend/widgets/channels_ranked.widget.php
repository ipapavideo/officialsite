<?php
function template_widget_channels_ranked()
{
	$cmodel		= VModel::load('channel', 'channel');
	$channels	= $cmodel->channels(array(), orientation(), 'all', 'popular', 'all', VCfg::get('template.defboot.channels_featured_nr'));
	
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title"><strong>'.__('popular-channels').'</strong></h3>';
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

  	return implode('', $output);
}
