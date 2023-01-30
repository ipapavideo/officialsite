<?php
function ajax_plugin_comment_wall_post()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	$types	= VData::get('comment_types', 'core');
	
	if (!isset($_POST['wall_id'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}
	
	$filter			= VF::factory('filter');
	$wall_id		= $filter->get('wall_id', 'INT');
	if (!$wall_id) {
		$data['msg']	= 'Invalid request (id)!';
		return json_encode($data);		
	}
	
	$allow_comment	= VCfg::get('profile.allow_comment');
	if (!$allow_comment) {
		$data['msg']	= __('comments-disabled');
		return json_encode($data);
	}
	
	$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	if ($allow_comment == '1' and !$user_id) {
		$data['msg']	= __('comments-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><strong>'.__('login').'</strong></a>'));
		return json_encode($data);
	}
	
	
	$cmodel		= VModel::load('comment', 'profile');
	if (!$wall = $cmodel->content($wall_id)) {
		$data['msg']	= 'Invalid request (wall)!';
		return json_encode($data);		
	}
	
    if (!upref($wall['wall_comments'], $wall['user_id'], $user_id)) {
        $data['msg'] = __('comment-disabled-user');
        return json_encode($data);
    }
	
	$tpl		= VF::factory('template');
	$token		= VCsrf::generate();
	$captcha	= VCfg::get('comment_captcha');
	
	$output		= array();
	$output[]	= p('comment', $wall_id, $user_id, 'wall', $token, 2);
	
	$data['status']	= 1;
	$data['code']	= implode('', $output);

	return json_encode($data);			
}
