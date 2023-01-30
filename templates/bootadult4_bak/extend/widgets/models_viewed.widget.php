<?php
function template_widget_models_viewed()
{
	$mmodel		= VModel::load('model', 'model');
	$timeline	= VCfg::get('template.bootadult4.models_viewed_timeline');
	$total		= $mmodel->total(array('orientation' => orientation(), 'timeline' => $timeline));
	$pagination	= VPagination::get(1, $total, VCfg::get('model.browse_per_page'));
	$models		= $mmodel->models(array(
		'orientation'	=> orientation(),
		'timeline'		=> $timeline,
		'order'			=> 'viewed'
	), VCfg::get('template.bootadult4.models_viewed_nr'));
	
	$timeline	= ($timeline != 'all') ? $timeline.'/' : '';
  	$url		= (VCfg::get('model.url')) ? REL_URL.LANG.ORIENTATION.'/pornstars/viewed/'.$timeline : REL_URL.LANG.ORIENTATION.'/models/viewed/'.$timeline;

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-md-8 text-center text-md-left">';
    $output[]   = '<h2>'.__('trending-models').'</h2>';
    $output[]   = '</div>';
    $output[]   = '<div class="col-md-4 d-flex justify-content-center justify-content-lg-end align-items-center">';
    $output[]   = '<a href="'.$url.'" class="btn btn-light btn-sm"><i class="fa fa-plus"></i> '.__('view-more').'</a>';
    $output[]   = '</div></div>';

    if ($models) {
        $output[]   = p('models', $models);
    } else {
        $output[]   = '<div class="none">'.__('no-models').'</div>';
    }

    $output[]   = '</div></div>';
  	
  	return implode('', $output);
}
