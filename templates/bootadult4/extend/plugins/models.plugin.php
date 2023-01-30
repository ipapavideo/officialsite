<?php
function template_plugin_models($models, $id = null, $class = 'models')
{
	$photo	= VModule::enabled('photo');
	$lazy   = VCfg::get('template.bootadult4.lazy');
	$output	= array('<div class="grid mx-auto '.$class.'">');
	
	foreach ($models as $model) {
		if (isset($model['object_id'])) {
			$model_id 	= $model['object_id'];
			$model 		= unserialize($model['object_data']);
		} else {
			$model_id	= $model['model_id'];
		}
		
		$url		= model_url($model['slug']);
		$name		= e($model['name']);
		$thumb		= MODEL_URL.'/'.$model_id.'.'.$model['ext'];
        $data_src   = ($lazy) ? ' data-src="'.$thumb.'"' : '';
        $thumb      = ($lazy) ? MODEL_URL.'/loading.gif' : $thumb;
        $lazyc      = ($lazy) ? ' lazy' : '';		
		$arrow 		= 'up';		
		$color 		= ' text-success';		
		
		if ($model['rank_prev'] > $model['rank']) {
			$arrow 	= 'down';
			$color 	= ' text-danger';
		}
		$output[]	= '<div id="model-'.$model_id.'" class="cell model">';
		$output[]	= '<div class="model-thumb">';
		$output[]	= '<a href="'.$url.'" title="'.$name.'"><img src="'.$thumb.'"'.$data_src.' class="thumb rounded'.$lazyc.'" alt="'.__('model-image', $name).'"></a>';
		$output[]	= '<div class="model-info model-videos"><i class="fa fa-video-camera"></i> '.$model['total_videos'].'</div>';
		
		if ($photo and isset($model['total_albums'])) {
			$output[]	= '<div class="model-info model-albums"><i class="fa fa-camera"></i> '.$model['total_albums'].'</div>';
		}
		
		$output[]	= '<div class="model-info model-rank">#'.$model['rank'].' <i class="fa fa-arrow-'.$arrow.$color.'"></i></div>';
		$output[]	= '<div class="model-info model-views"><i class="fa fa-eye"></i> '.VText::formatNum($model['total_views']).'</div>';
		$output[]	= '</div>';
		$output[]   = '<h5 class="model-title"><a href="'.$url.'" title="'.$name.'">'.$name.'</a></h5>';
		$output[]	= '</div>';
	}
	
	$output[]	= '</div>';
	
	return implode("\n", $output);
}
