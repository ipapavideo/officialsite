<?php
function ajax_plugin_video_playlists()
{
	if (!VAuth::loggedin() or !isset($_GET['id'])) {
		return;
	}

    VLanguage::load('frontend.playlist');
    
    $filter		= VF::factory('filter');
    $video_id	= $filter->get('id', 'INT', 'GET');
    $user_id	= (int) VSession::get('user_id');
    $pmodel		= VModel::load('playlist', 'playlist');
    $args		= array('user_id' => $user_id, 'video_id' => $video_id, 'order' => 'recent');
    $playlists	= $pmodel->playlists($args, 100);
    
    $code		= array();
    $code[]		= '<div id="playlist-create-container"></div>';
    $code[]		= '<div class="pull-left"><strong>'.__('my-playlists').'</strong></div>';
    $code[]		= '<div class="pull-right"><button class="btn btn-xs btn-submit" id="playlist-new">'.__('new-playlist').'</button></div>';
    $code[]		= '<div class="clearfix"></div>';
    $class		= ($playlists) ? ' playlists-scroll' : ' playlists-none';
    $code[]		= '<div class="playlists-container'.$class.'">';
    
    if ($playlists) {
  		$code[]	= '<ul class="nav nav-stacked nav-list">';
  		
  		foreach ($playlists as $playlist) {
  			$added	= ($playlist['video_id']) ? '<small class="text-success"><i class="fa fa-check"></i> '.__('already-added').'</small> ' : '';
  			$code[] = '<li id="playlist-'.$playlist['playlist_id'].'-'.$video_id.'"><a href="#add-to-playlist" data-playlist="'.$playlist['playlist_id'].'" data-video="'.$video_id.'" class="add-to-playlist">'.e($playlist['name']).' ('.$playlist['total_videos'].')'.$added.'</a></li>';
  		}
  		
  		$code[]	= '</ul>';
    } else {
  		$code[]	= '<div class="playlists-none">'.__('no-playlists').'</div>';
    }
    
    $code[]		= '</div>';
    
    return implode('', $code);
}
