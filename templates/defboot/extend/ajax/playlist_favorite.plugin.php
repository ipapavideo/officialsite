<?php
function ajax_plugin_playlist_favorite()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
	
    VLanguage::load('frontend.playlist');
    
    if (VCfg::get('playlist.allow_favorite') != '1') {
        $data['msg'] = __('favorite-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['playlist_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('favorite-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter			= VF::factory('filter');
    $playlist_id	= $filter->get('playlist_id', 'INT');
    $fmodel			= VModel::load('favorite', 'playlist');

	if (!$playlist = $fmodel->content($playlist_id)) {
        $data['msg'] = __('playlist-invalid');
        return json_encode($data);
    }
	
	if ($fmodel->exists($playlist_id, $user_id)) {
        $data['msg'] = __('playlist-favorite-already');
        return json_encode($data);
	}
	
	$owner_id	= $playlist['user_id'];
	if ($owner_id == $user_id) {
        $data['msg'] = __('playlist-favorite-owner');
        return json_encode($data);
	}
	
	$fmodel->add($playlist_id, $user_id);
	
	$cache	= VF::factory('cache');
	$cache->del('playlist-favorite-exists-'.$playlist_id.'-'.$user_id);
	$cache->set('playlist-favorite-content-'.$playlist_id);
	$cache->set('playlist-favorite-users-'.$playlist_id);
	
    if (VCfg::get('user.activity')) {
        $amodel = VModel::load('activity', 'core');
        $amodel->add($user_id, 'playlist-favorite', array('id' => $playlist_id, 'data' => $playlist), 1);
    }
    
    if (VCfg::get('user.points')) {
        VModel::load('points', 'user')->add($user_id, 'playlist-favorite-add');
    }    
			
	VModel::load('playlist', 'playlist')->update($playlist_id, array('total_favorites' => 'total_favorites+1'));
	VModel::load('user', 'user')->update($user_id, array('favorite_playlists' => 'favorite_playlists+1'), 'user_stats', false);

	$data['status']	= 1;
	
	return json_encode($data);	
}
