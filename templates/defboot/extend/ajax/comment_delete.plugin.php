<?php
function ajax_plugin_comment_delete()
{
	$data 	= array('status' => 0, 'msg' => '', 'debug' => '');
	$types	= VData::get('comment_types', 'core');
	if (!isset($_POST['comment_id']) or !isset($_POST['type']) or !isset($_POST['content_id'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}
	
	if (!VAuth::loggedin()) {
		$data['msg']	= 'Invalid request (login)!';
		return json_encode($data);
	}

	$filter		= VF::factory('filter');
	$comment_id	= $filter->get('comment_id', 'INT');
	$type		= $filter->get('type');
	$content_id	= $filter->get('content_id');
	$user_id	= (int) VSession::get('user_id');
	
	if (!isset($types[$type])) {
		$data['msg']	= 'Invalid request (type)!';
		return json_encode($data);
	}
	
	$module		= ($type == 'wall') ? 'profile' : $type;
	$cmodel		= VModel::load('comment', $module);
	if (!$comment = $cmodel->get($comment_id)) {
		$data['msg']	= 'Invalid request (comment)!';
		return json_encode($data);
	}
	
	if ($user_id != $comment['user_id'] and !VAuth::group('Moderator', true)) {
		$data['msg']	= 'Invalid request (perms)!';
		return json_encode($data);		
	}
	
	if (VCfg::get('user.points')) {
		$pmodel	= VModel::load('points', 'user');
	}
		
	if ($comment['parent_id'] == '0' and $comment['replies']) {		
		$comments	= $cmodel->comments('c.parent_id = ? AND c.'.$type.'_id = ?', 'ii', array($comment_id, $content_id), 65000, 'c.comment_id', 'ASC', false);		
		if ($comments) {
			foreach ($comments as $reply) {
				$cmodel->del($reply['comment_id'], $content_id, $reply['user_id']);
				if ($reply['user_id'] and isset($pmodel)) {
					$pmodel->del($reply['user_id'], $type.'-comment-del');
				}				
			}
		}
	}
	
	$cmodel->del($comment_id, $content_id, $user_id);
	if (isset($pmodel)) {
		$pmodel->del($user_id, $type.'-comment-del');
	}		
	
	$data['status']	= 1;
	
	return json_encode($data);			
}
