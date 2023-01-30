<?php
function ajax_plugin_comment_pagination()
{
	$data 	= array('status' => 0, 'code' => '', 'end' => 0, 'page' => 2, 'msg' => '', 'debug' => '');
	$types	= VData::get('comment_types', 'core');
	if (!isset($_POST['content_id']) or !isset($_POST['page']) or !isset($_POST['type'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}

	$filter		= VF::factory('filter');
	$type		= $filter->get('type');
	
	if (!isset($types[$type])) {
		$data['msg']	= 'Invalid request (type)!';
		return json_encode($data);
	}
	
	$module			= ($type == 'wall') ? 'profile' : $type;
	if (!VCfg::get($module.'.comments')) {
		$data['msg']	= __('comments-disabled');
		return json_encode($data);
	}

	$content_id		= $filter->get('content_id', 'INT');
	$user_id		= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	$cmodel			= VModel::load('comment', $module);
	if (!$content_id or !$content = $cmodel->content($content_id)) {
		$data['msg']	= 'Invalid request (content)!';
		return json_encode($data);
	}
	
	$post_reply		= false;
	$allow_comment	= VCfg::get($module.'.allow_comment');
	$callow_comment	= (isset($content['allow_comment'])) ? $content['allow_comment'] : true;
	if ($callow_comment and(($allow_comment === '1' and $user_id) or $allow_comment == '2')) {
		$post_reply	= true;
	}
	
	$page		= $filter->get('page', 'INT');
	$page_limit	= ($page >= 2) ? $page-1 : $page;
	$perpage	= VCfg::get($module.'.comments_per_page');
	$limit		= ($page_limit*$perpage).', '.($perpage+1);
	$comments	= $cmodel->comments('c.'.$type.'_id = ? AND c.parent_id = 0 AND c.status = 1', 'i', $content_id, $limit);
	if (!$comments) {
		$data['msg']	= __('no-comments');
		return json_encode($data);
	} 
	
	$tpl		= VF::factory('template');	
	$code		= p('comments', $comments, 0, $content_id, $type, 0, $post_reply);

	$data['status']	= 1;
	$data['code']	= $code;
	$data['page']	= $page+1;
	
	if (count($comments) < 11) {
		$data['end']	= 1;
	}
  
	return json_encode($data);			
}
