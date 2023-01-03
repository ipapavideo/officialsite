<?php
function ajax_plugin_user_video_history_delete()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.user');
    
    if (!isset($_POST['video_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('video-history-delete-login');
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $video_id	= $filter->get('video_id', 'INT');
    
    $vmodel		= VModel::load('video', 'user');
    $vmodel->historyDelete($video_id, $user_id);
	
	$data['msg']	= __('video-history-deleted');
	$data['status']	= 1;
	
	return json_encode($data);	
}
