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
			
			$code[]	= '<div id="message-'.$message['msg_id'].'" class="media" data-id="'.$message['msg_id'].'">';
			$code[]	= '<i class="fa fa-arrow-'.$icon.'"></i>';
			$code[]	= '<div class="media-body ml-1">';
			$code[]	= '<h6>'.$username.' <small class="text-muted">'.VDate::nice($message['send_time']).' <button class="btn btn-ns btn-delete" data-id="'.$message['msg_id'].'"><i class="fa fa-close text-danger"></i></button></small></h6>';
			$code[]	= '<p>'.nl2br(e($message['message'])).'</p>';
			$code[]	= '</div></div>';
		}
	
		$data['status']	= 1;
		$data['code']	= implode('', $code);
	}
	
	return json_encode($data);
}
