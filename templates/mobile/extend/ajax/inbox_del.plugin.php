<?php
function ajax_plugin_inbox_del()
{
	$data 		= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	if (!isset($_POST['sender_id']) or !$_POST['sender_id']) {
	    $data['msg']	= 'Invalid request!';
	    return json_encode($data);
	}

	$receiver_id		= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	if (!$receiver_id) {
	    $data['msg']	= 'Invalid request (receiver)!';
	    return json_encode($data);
	}
	
	$filter		= VF::factory('filter');
	$sender_id	= $filter->get('sender_id', 'INT');
	
	$mmodel		= VModel::load('message', 'message');
	$mmodel->delChat($receiver_id, $sender_id);
	
	$data['status']	= 1;
	
	return json_encode($data);
}
