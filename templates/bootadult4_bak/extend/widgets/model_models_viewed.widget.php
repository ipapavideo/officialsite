<?php
function template_widget_model_models_viewed()
{
    $mmodel     = VModel::load('model', 'model');
    $timeline   = VCfg::get('template.bootadult4.models_viewed_timeline');
    $total      = $mmodel->total(array('orientation' => orientation(), 'timeline' => $timeline));
    $pagination = VPagination::get(1, $total, 5);
    $models     = $mmodel->models(array(
        'orientation'   => orientation(),
        'timeline'      => $timeline,
        'order'         => 'viewed'
    ), 5);

    $timeline   = ($timeline != 'all') ? $timeline.'/' : '';
    $url_all    = (VCfg::get('model.url')) ? REL_URL.LANG.ORIENTATION.'/pornstars/viewed/'.$timeline : REL_URL.LANG.ORIENTATION.'/models/viewed/'.$timeline;
	
	$output		= array();
	$output[]	= '<div class="d-none d-lg-block">';
	$output[]	= '<hr width="90%">';
	$output[]	= '<div class="w-100 font-weight-bold text-muted mb-2">'.__('viewed').' '.__('models').'</div>';
	$output[]	= '<ul class="list-unstyled">';
	
	foreach ($models as $model) {
        $model_id   = $model['model_id'];
        $url        = model_url($model['slug']);
        $name       = e($model['name']);
        $arrow      = 'up';
        $color      = ' text-success';

        if ($model['rank_prev'] > $model['rank']) {
            $arrow  = 'down';
            $color  = ' text-danger';
        }
	
		$output[]	= '<li class="media mb-3">';
		$output[]	= '<a href="'.$url.'" title="'.$name.'"><img src="'.MODEL_URL.'/'.$model['model_id'].'.'.$model['ext'].'" class="rounded mr-2" alt="'.__('model-avatar', $name).'" width="50"></a>';
		$output[]	= '<div class="media-body">';
		$output[]	= '<h6 class="mb-0"><a href="'.$url.'" title="'.$name.'">'.$name.'</a></h6>';
		$output[]	= '<small class="text-muted d-block">'.__('rank').': <strong>'.$model['rank'].'</strong> <i class="fa fa-arrow-'.$arrow.$color.'"></i></small>';
		$output[]	= '<small class="text-muted d-block">'.__('videos').': <strong>'.VText::formatNum($model['total_videos']).'</strong></small>';
		$output[]	= '<small class="text-muted d-block">'.__('viewed').': <strong>'.VText::formatNum($model['total_views']).'</strong></small>';
		$output[]	= '</div>';
		$output[]	= '</li>';
	}
	
	$output[]	= '</ul>';
	$output[]	= '<div class="text-center"><a href="'.$url_all.'" class="btn btn-sm btn-primary rounded-pill">'.__('view-all').'</a></div>';
	$output[]	= '</div>';
	
	return implode("\n", $output);
}
