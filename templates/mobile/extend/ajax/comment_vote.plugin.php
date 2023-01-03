<?php
function ajax_plugin_comment_vote()
{
	$data 	= array('status' => 0, 'likes' => 0, 'class' => 'down', 'msg' => '', 'debug' => '');
	$types	= VData::get('comment_types', 'core');
	if (!isset($_POST['comment_id']) or !isset($_POST['type']) or !isset($_POST['vote'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}

	$filter		= VF::factory('filter');
	$comment_id	= $filter->get('comment_id', 'INT');
	$type		= $filter->get('type');
	$vote		= $filter->get('vote');
	
	if (!isset($types[$type])) {
		$data['msg']	= 'Invalid request (type)!';
		return json_encode($data);
	}
	
	if ($vote != 'up' and $vote != 'down') {
		$data['msg']	= 'Invalid request (vote)!';
		return json_encode($data);
	}
	
	$module		= ($type == 'wall') ? 'profile' : $type;
	$cmodel		= VModel::load('comment', $module);
	$likes		= $cmodel->getLikes($comment_id);
	$likes		= ($vote == 'up') ? $likes+1 : $likes;
	if ($likes === false) {
		$data['msg']	= 'Invalid comment!';
		return json_encode($data);
	}
	
	$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	$ip			= VServer::ipv();
	
	if ($cmodel->getVote($comment_id, $ip, $user_id)) {
		$data['msg']	= __('already-voted');
		return json_encode($data);
	}
	
	$cmodel->addVote($comment_id, $ip, $user_id);
	$cmodel->update($comment_id, array('likes' => $likes, 'rated_by' => 'rated_by+1'));
	
	if ($user_id && VCfg::get('user.points')) {
		VModel::load('points', 'user')->add($user_id, $type.'-comment-vote');
	}
	
	$data['likes']	= $likes;
	$data['class']	= ($vote == 'up') ? 'down' : 'up';
	$data['status']	= 1;

	return json_encode($data);			
}
