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
    $code[]		= '<div class="row">';
    $code[]		= '<div class="col-6"><strong>'.__('my-playlists').'</strong></div>';
    $code[]		= '<div class="col-6 d-flex justify-content-end"><button class="btn btn-primary btn-sm" id="playlist-new">'.__('new-playlist').'</button></div>';
    $code[]		= '</div>';

    $code[]		= '<div class="playlists-container py-3">';
    
    if ($playlists) {
  		$code[]	= '<ul class="list-group list-group-sm list-group-playlist playlists-scroll">';
  		
  		foreach ($playlists as $playlist) {
  			$added	= ($playlist['video_id']) ? '<i class="fa fa-check text-success"></i> ' : ' ';
  			$code[]	= '<a href="#" class="list-group-item list-group-item-action" id="playlist-'.$playlist['playlist_id'].'-'.$video_id.'" data-playlist="'.$playlist['playlist_id'].'" data-video="'.$video_id.'">'.$added.e($playlist['name']).' <span id="playlist-'.$playlist['playlist_id'].'" class="badge badge-primary badge-pill pull-right">'.$playlist['total_videos'].'</span></a>';
  		}
  		
  		$code[]	= '</ul>';
    } else {
  		$code[]	= '<div class="playlists-none none none-small">'.__('no-playlists').'</div>';
    }
    
    $code[]		= '</div>';
    
    return implode('', $code);
}
