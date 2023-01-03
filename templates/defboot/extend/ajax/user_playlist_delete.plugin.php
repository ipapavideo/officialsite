<?php
function ajax_plugin_user_playlist_delete()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.user');
    VLanguage::load('frontend.playlist');
    
    if (VCfg::get('playlist.allow_delete') != '1') {
        $data['msg'] = __('playlist-delete-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['playlist_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('playlist-delete-login');
        return json_encode($data);
    }
        
    $filter			= VF::factory('filter');
    $playlist_id	= $filter->get('playlist_id', 'INT');
    
    $pmodel		= VModel::load('playlist', 'playlist');
	if (!$playlist = $pmodel->get($playlist_id, $user_id)) {
		$data['msg']	= 'Invalid request (playlist)';
		return json_encode($data);
	}
	
    $mark			= (VCfg::get('playlist.delete_method') == 'mark') ? true : false;
    $pmodel->del($playlist_id, $mark);
	
	$data['msg']	= __('playlist-deleted');
	$data['status']	= 1;
	
	return json_encode($data);	
}
