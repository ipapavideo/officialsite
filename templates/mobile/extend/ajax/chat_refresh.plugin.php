<?php
function ajax_plugin_chat_refresh()
{
	$data 		= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	if (!isset($_POST['sender_id']) or !$_POST['sender_id'] or
	    !isset($_POST['msg_id']) or !$_POST['msg_id']) {
	    $data['msg']	= 'Invalid request!';
	    return json_encode($data);
	}

	$receiver_id		= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	if (!$receiver_id) {
	    $data['msg']	= 'Invalid request (receiver)!';
	    return json_encode($data);
	}
	
	$filter	= VF::factory('filter');
	$sender_id	= $filter->get('sender_id', 'INT');
	$msg_id		= $filter->get('msg_id', 'INT');
	
	$mmodel	= VModel::load('message', 'message');
	if (!$user = $mmodel->user('', $sender_id)) {
		$data['msg']	= 'Invalid request (sender)!';
		return json_encode($data);
	}
	
	VLanguage::load('frontend.message');
	
	if ($messages = $mmodel->chat($receiver_id, $sender_id, $msg_id, VCfg::get('message.refresh'))) {
		$code			= array();
		foreach ($messages as $message) {
			$icon		= ($message['sender_id'] == $sender_id) ? 'down' : 'up';
			$username	= ($message['sender_id'] == $sender_id) ? e($user['username']) : VSession::get('username');
		
			$code[]	= '<div id="message-'.$message['msg_id'].'" class="message" data-id="'.$message['msg_id'].'">';
    		$code[]	= '<div class="message-icon"><i class="fa fa-arrow-'.$icon.'"></i></div>';
    		$code[]	= '<div class="message-username btn-color"><strong>'.$username.'</strong></div>';
    		$code[]	= '<div class="message-info">'.VDate::nice($message['send_time']).' <button class="btn btn-ns btn-menu btn-delete" data-id="'.$message['msg_id'].'"><i class="fa fa-close"></i></button></div>';
    		$code[]	= '<div class="clearfix"></div>';
    		$code[]	= '<div class="message-body">'.nl2br(e($message['message'])).'</div>';
    		$code[]	= '</div>';
		}
	
		$data['status']	= 1;
		$data['code']	= implode('', $code);
	}
	
	return json_encode($data);
}
