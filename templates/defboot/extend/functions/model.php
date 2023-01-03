<?php
function display_models($models, $id = null, $class = null)
{
	$id			= ($id) ? '-'.$id : '';
	$class		= ($class) ? '-'.$class : '';
	
	$output		= array();
	$output[]	= '<ul class="models'.$class.'">';
	
	foreach ($models as $model) {
		$views	= ($model['total_views'] == '1') ? __('view') : __('views');
		$arrow 	= 'up';
		$color 	= 'text-success';
		if ($model['rank_prev'] > $model['rank']) {
			$arrow 	= 'down';
			$color 	= 'text-danger';
		}
		
		$output[]	= '<li id="model-'.$model['model_id'].$id.'" class="model">';
		$output[]	= '<a href="'.model_url($model['slug'], false).'" title="'.e($model['name']).'" class="image">';
		$output[]	= '<div class="model-thumb">';
		$output[]	= '<img src="'.MODEL_URL.'/'.$model['model_id'].'.'.$model['ext'].'" alt="'.__('model-avatar', e($model['name'])).'">';
		$output[]	= '<div class="model-videos"><i class="fa fa-video-camera"></i> '.$model['total_videos'].'</div>';
		$output[]	= '<div class="model-rank">'.__('rank').': <strong>'.$model['rank'].'</strong> <i class="'.$color.' fa fa-arrow-'.$arrow.'"></i></div>';
		$output[]	= '</div>';
		$output[]	= '</a>';
		$output[]	= '<span class="model-title"><a href="'.model_url($model['slug'], false).'" title="'.e($model['name']).'">'. e($model['name']).'</a></span>';
		$output[]	= '<span class="views">'.$model['total_views'].' '.$views.'</span>';
		$output[]	= '</li>';
	}
	
	$output[]	= '</ul>';
	
	return implode('', $output);
}
