<?php
function display_channels($channels, $id = null, $class = null)
{
    $id         = ($id) ? '-'.$id : '';
    $ids		= array();
    $class      = ($class) ? '-'.$class : '';

    $output     = array();
    $output[]   = '<ul class="channels'.$class.'">';
    
    foreach ($channels as $channel) {
  		$ids[]	= $channel['channel_id'];
  		$arrow 	= 'up';
  		$color 	= 'text-success';
  		if ($channel['rank_prev'] > $channel['rank']) {
  			$arrow 	= 'down';
  			$color 	= 'text-danger';
  		}
    
  		$output[]	= '<li id="channel-'.$channel['channel_id'].$id.'" class="channel">';
  		$output[]	= '<a href="'.REL_URL.LANG.'/channel/'.e($channel['slug']).'/" title="'.e($channel['name']).'" class="image">';
  		$output[]	= '<div class="channel-thumb">';
  		$output[]	= '<img src="'.CHANNEL_URL.'/'.$channel['channel_id'].'.'.$channel['thumb'].'" alt="'.__('channel-avatar', e($channel['name'])).'">';
  		$output[]	= '<div class="channel-videos"><i class="fa fa-video-camera"></i> '.$channel['total_videos'].'</div>';
  		$output[]	= '<div class="channel-rank">'.__('rank').': <strong>'.$channel['rank'].'</strong> <i class="'.$color.' fa fa-arrow-'.$arrow.'"></i></div>';
  		$output[]	= '</div>';
  		$output[]	= '</a>';
  		$output[]	= '<span class="channel-title"><a href="'.REL_URL.LANG.'/channel/'.e($channel['slug']).'/" title="'.e($channel['name']).'">'.e($channel['name']).'</a></span>';
  		$output[]	= '</li>';
    }
    
	$output[]	= '</ul>';
	
	p('ctr_channels', $ids);
	
	return implode('', $output);
}
