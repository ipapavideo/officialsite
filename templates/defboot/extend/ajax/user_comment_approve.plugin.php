<?php
function ajax_plugin_user_comment_approve()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.user');
    
    if (!isset($_POST['comment_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('comment-approve-login');
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $comment_id	= $filter->get('comment_id', 'INT');
    
    $cmodel		= VModel::load('comment', 'profile');
    if (!$wall = $cmodel->wall($comment_id)) {
  		$data['msg']	= 'Invalid request (wall)!';
  		return json_encode($data);
    }
    
    if ($wall['user_id'] != $user_id) {
  		$data['msg']	= 'Invalid request (owner)!';
  		return json_encode($data);
    }
    
    $status	= (VCfg::get('profile.approve_comments') == '1') ? 2 : 1;
    $cmodel->update($comment_id, array('status' => $status));
    
	$data['msg']	= ($status === 1) ? __('comment-approved') : __('comment-approve-admin');
	$data['status']	= 1;
	
	return json_encode($data);	
}
