<?php
function ajax_plugin_spam()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	$types	= VData::get('comment_types', 'core');
	if (!isset($_POST['content_id']) or !isset($_POST['comment_id']) or !isset($_POST['type'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}

	$filter		= VF::factory('filter');
	$type		= $filter->get('type');
	
	if (!isset($types[$type])) {
		$data['msg']	= 'Invalid request (type)!';
		return json_encode($data);
	}
		
	$comment_id	= $filter->get('comment_id', 'INT');
	$content_id	= $filter->get('content_id', 'INT');	
	$type_id	= $types[$type];
	$user_id	= (VAuth::loggedin()) ? VSession::get('user_id') : 0;
	
	$smodel		= VModel::load('spam', 'core');
	if ($spam_id = $smodel->add(array(
		'comment_id'	=> $comment_id,
		'content_id'	=> $content_id,
		'user_id'		=> $user_id,
		'type'			=> $type_id))) {
		$cmodel	= VModel::load('comment', $type);
		$cmodel->update($comment_id, array('spam' => 'spam+1'));
		if ($data = $cmodel->get($comment_id, array('user_id', 'ip'))) {
			if ($data['user_id']) {
				$smodel->addStatsUser($data['user_id']);
			} elseif ($data['ip']) {
				$smodel->addStatsIP($data['ip']);
			}
		}
		
		$data['status']	= 1;
		$data['msg']	= __('spam-success');
	} else {
		$data['msg']	= __('spam-error');
	}

	return json_encode($data);			
}
