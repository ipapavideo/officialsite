<?php
function template_widget_models_viewed()
{
	$mmodel		= VModel::load('model', 'model');
	$timeline	= VCfg::get('template.defboot.models_viewed_timeline');
	$total		= $mmodel->total(array('orientation' => orientation(), 'timeline' => $timeline));
	$pagination	= VPagination::get(1, $total, VCfg::get('model.browse_per_page'));
	$models		= $mmodel->models(array(
		'orientation'	=> orientation(),
		'timeline'		=> $timeline,
		'order'			=> 'viewed'
	), VCfg::get('template.defboot.models_viewed_nr'));
	
	$timeline	= ($timeline != 'all') ? $timeline.'/' : '';
  	$url		= (VCfg::get('model.url')) ? REL_URL.LANG.ORIENTATION.'/pornstars/viewed/'.$timeline : REL_URL.LANG.ORIENTATION.'/models/viewed/'.$timeline;
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title pull-left"><strong>'.__('trending-models').'</strong></h3>';
    $output[]   = '<a href="'.$url.'" class="btn btn-menu btn-xs pull-right">'.__('view-more').'</a>';
    $output[]   = '<div class="clearfix"></div>';    
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($models) {
  		if (!function_exists('display_models')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/model.php';
  		}
  		
  		$output[]	= display_models($models);
  	} else {
  		$output[]	= '<div class="none">'.__('no-models').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	return implode('', $output);
}
