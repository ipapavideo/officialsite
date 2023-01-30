<?php
function template_widget_models_featured()
{
	$mmodel		= VModel::load('model', 'model');
	$models		= $mmodel->models(array(
		'orientation'	=> orientation(),
		'featured'		=> 1,
		'order'			=> 'featured'
	), VCfg::get('template.bootadult4.models_featured_nr'));

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<h2 class="w-100">'.__('featured-models').'</h2>';

    if ($models) {
        $output[]   = p('models', $models);
    } else {
        $output[]   = '<div class="none">'.__('no-models').'</div>';
    }

    $output[]   = '</div></div>';

  	return implode('', $output);
}