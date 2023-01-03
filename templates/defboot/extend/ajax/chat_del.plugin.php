<?php
function ajax_plugin_chat_del()
{
	$data 		= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	if (!isset($_POST['msg_id']) or !$_POST['msg_id']) {
	    $data['msg']	= 'Invalid request!';
	    return json_encode($data);
	}

	$user_id		= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	if (!$user_id) {
	    $data['msg']	= 'Invalid request (sender)!';
	    return json_encode($data);
	}
	
	$filter	= VF::factory('filter');
	$msg_id	= $filter->get('msg_id', 'INT');
	
	$mmodel	= VModel::load('message', 'message');
	$mmodel->del($msg_id, $user_id);
	
	$data['status']	= 1;
	
	return json_encode($data);
}
