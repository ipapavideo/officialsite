<?php
function ajax_plugin_playlist_add()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
	VLanguage::load('frontend.playlist');
	
	if (!isset($_POST['playlist_id']) or !isset($_POST['video_id'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}
	
	$filter			= VF::factory('filter');
	$playlist_id	= $filter->get('playlist_id', 'INT');
	$video_id		= $filter->get('video_id', 'INT');
	$user_id		= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	
	if (!$user_id) {
		$data['msg']	= 'Invalid request (login)!';
		return json_encode($data);
	}
	
	$pmodel			= VModel::load('playlist', 'playlist');
	if (!$playlist = $pmodel->get($playlist_id, $user_id)) {
		$data['msg']	= 'Invalid request (playlist:user)!';
		return json_encode($data);
	}
	
	if ($pmodel->alreadyAdded($playlist_id, $video_id)) {
		$data['status']	= 2;
		$data['code']	= '<span class="text-danger disabled">'.e($playlist['name']).' ('.$playlist['total_videos'].') <small class="text-danger"><i class="fa fa-check"></i>'.__('already-added').'</small></span>';
		return json_encode($data);
	}
	
	if ($pmodel->addVideo($playlist_id, $video_id)) {	
		$cache	= VF::factory('cache');
		$cache->del('playlist-video-exists-'.$playlist_id.'-'.$video_id);
		$cache->del('playlist-videos-'.$playlist_id.'-'.LANG_ID);
		
  		if (VCfg::get('user.points')) {
      		VModel::load('points', 'user')->add($user_id, 'playlist-video-add');
  		}		
		
		$data['status']	= 1;
		$data['msg']	= 'Success!';
		$data['code']	= '<span class="text-success disabled">'.e($playlist['name']).' ('.($playlist['total_videos']+1).') <small class="text-success"><i class="fa fa-check"></i></small></span>';
	}
	
	return json_encode($data);
}
?>
