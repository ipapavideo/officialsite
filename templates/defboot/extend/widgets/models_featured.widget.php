<?php
function template_widget_models_featured()
{
	$mmodel		= VModel::load('model', 'model');
	$models		= $mmodel->models(array(
		'orientation'	=> orientation(),
		'featured'		=> 1,
		'order'			=> 'featured'
	), VCfg::get('template.defboot.models_featured_nr'));
	
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title"><strong>'.__('featured-models').'</strong></h3>';
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($models) {
  		if (!function_exists('display_models')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/model.php';
  		}
  		
  		$output[]	= display_models($models);
  	} else {
  		$output[]	= '<div class="none">'.__('no-featured-models').'</div>';
  	}
  	
  	$output[]	= '</div></div>';

  	return implode('', $output);
}