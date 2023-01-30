<?php
function ajax_plugin_user_friend_delete()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.user');
    
    if (!isset($_POST['user_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('friend-delete-login');
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $friend_id	= $filter->get('user_id', 'INT');
    
    $fmodel		= VModel::load('friend', 'profile');
    $fmodel->del($user_id, $friend_id);
    
	$data['msg']	= __('friend-deleted');
	$data['status']	= 1;
	
	return json_encode($data);	
}
