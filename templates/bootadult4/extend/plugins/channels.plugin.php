<?php
function template_plugin_channels($channels, $id = null, $class = 'channels')
{
	$lazy	= VCfg::get('template.bootadult4.lazy');
	$output	= array('<div class="grid mx-auto '.$class.'">');
	
	foreach ($channels as $channel) {
		$channel_id	= $channel['channel_id'];
		$url		= REL_URL.LANG.'/channel/'.e($channel['slug']).'/';
		$name		= e($channel['name']);
		$thumb		= CHANNEL_URL.'/'.$channel_id.'.'.$channel['thumb'];		
        $data_src   = ($lazy) ? ' data-src="'.$thumb.'"' : '';
        $thumb      = ($lazy) ? CHANNEL_URL.'/loading.gif' : $thumb;
        $lazyc      = ($lazy) ? ' lazy' : '';
		$arrow 		= 'up';		
		$color 		= ' text-success';
		
		if ($channel['rank_prev'] > $channel['rank']) {
			$arrow 	= 'down';
			$color 	= ' text-danger';
		}
		
		$output[]	= '<div id="channel-'.$channel_id.'" class="cell channel">';
		$output[]	= '<div class="channel-thumb">';
		$output[]	= '<a href="'.$url.'" title="'.$name.'"><img src="'.$thumb.'"'.$data_src.' class="thumb rounded'.$lazyc.'" alt="'.__('channel-avatar', $name).'"></a>';
		$output[]	= '<div class="channel-info channel-videos"><i class="fa fa-video-camera"></i> '.$channel['total_videos'].'</div>';
		
		$output[]	= '<div class="channel-info channel-rank">#'.$channel['rank'].' <i class="fa fa-arrow-'.$arrow.$color.'"></i></div>';
		$output[]	= '<div class="channel-info channel-views"><i class="fa fa-eye"></i> '.VText::formatNum($channel['total_views']).'</div>';
		$output[]	= '</div>';
		$output[]   = '<h5 class="channel-title"><a href="'.$url.'" title="'.$name.'">'.$name.'</a></h5>';
		$output[]	= '</div>';
	}
	
	$output[]	= '</div>';
	
	return implode("\n", $output);
}
