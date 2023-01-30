<?php
function ajax_plugin_playlist()
{
	if (!VAuth::loggedin() or !isset($_GET['id'])) {
		return;
	}

    VLanguage::load('frontend.playlist');
    
    $filter     = VF::factory('filter');
    $video_id   = $filter->get('id', 'INT', 'GET');
    $user_id    = (int) VSession::get('user_id');
    $pmodel     = VModel::load('playlist', 'playlist');
    $args       = array('user_id' => $user_id, 'video_id' => $video_id, 'order' => 'recent');
    $playlists  = $pmodel->playlists($args, 100);

    $output     = array();
    $output[]   = '<div id="playlists-modal" class="modal fade" tabindex="-1" role="dialog">';
    $output[]   = '<div class="modal-dialog modal-sm" role="document">';
    $output[]   = '<div class="modal-content">';
    $output[]   = '<div class="modal-header">';
    $output[]   = '<h4 class="modal-title">'.__('my-playlists').'</h4>';
    $output[]   = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>';
    $output[]   = '</div>';
    $output[]   = '<div class="modal-body">';
    
    if ($playlists) {
  		$output[]	= '<ul class="list-group list-group-sm list-group-flush">';
  		foreach ($playlists as $playlist) {
      		$added  	= ($playlist['video_id']) ? '<i class="fa fa-check text-success"></i> ' : ' ';
      		$output[]	= '<a href="#" class="list-group-item list-group-item-action" id="playlist-'.$playlist['playlist_id'].'-'.$video_id.'" data-playlist="'.$playlist['playlist_id'].'" data-video="'.$video_id.'">'.$added.e($playlist['name']).' <span id="playlist-'.$playlist['playlist_id'].'" class="badge badge-primary badge-pill pull-right">'.$playlist['total_videos'].'</span></a>';
  		}
  		$output[]	= '</ul>';
    } else {
  		$output[]	= '<div class="none text-muted">'.__('no-playlists').'</div>';
    }
    
    $output[]	= '</div>';    
    $output[]   = '<div class="modal-footer">';
    $output[]	= '<div class="w-100 text-center">';
    $output[]	= '<button class="btn btn-sm btn-primary" id="playlist-new" data-id="'.$video_id.'">'.__('new-playlist').'</button>';
    $output[]	= '</div>';
    $output[]	= '</div>';
    $output[]   = '</div></div></div>';

    return implode('', $output);
}
