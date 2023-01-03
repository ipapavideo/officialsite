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
	
	$token		= VCsrf::generate();
	$captcha	= VCfg::get('comment_captcha');
	
	$output		= array();
	$output[]	= '<div class="post-comment">';
	$output[]	= '<div id="response-comment" class="alert alert-response content-group" style="display: none;"></div>';
	$output[]	= '<input name="csrf_token_comment" type="hidden" value="'.$token.'">';
	$output[]	= '<div class="post-comment-image">';
	$output[]	= '<img src="'.USER_URL.'/'.avatar(true).'" alt="'.__('user-avatar').'" class="img-rounded">';
	$output[]	= '</div>';
	$output[]	= '<div class="post-comment-message">';
	$output[]	= '<textarea name="comment" id="comment-textarea-'.$wall_id.'" class="form-control elastic" rows="3" placeholder="'.__('comment').'"></textarea>';
	$output[]	= '<div class="post-comment-footer">';
		
	if ($captcha) {
		if ($captcha === 2 and VCfg::get('recaptcha')) {	
			$output[]	= '<div class="g-recaptcha" data-sitekey="'.VCfg::get('recaptcha_site_key').'" id="recaptcha" data-theme="dark"></div>';
		} else {
			$output[]	= '<div class="captcha-math">';
			$output[]	= '<img src="'.REL_URL.'/captcha/?rand='.rand(1, 100).'" id="captcha" class="captcha-reload" alt="" data-toggle="tooltip" data-placement="top" title="'.__('click-to-reload-image').'">';
			$output[]	= '<input name="captcha-verify" type="text" id="comment-captcha-'.$wall_id.'" class="form-control">';
			$output[]	= '</div>';
		}
	}
	
	$output[]	= '<small><span id="remaining">500</span> '.__('characters-left').'</small>';
	$output[]	= '<button id="post-comment-'.$wall_id.'" class="btn btn-xs btn-submit pull-right" data-id="'.$wall_id.'" data-type="wall">'.__('post-comment').'</button>';
	$output[]	= '<div class="clearfix"></div>';
	$output[]	= '</div>';
	$output[]	= '</div>';
	$output[]	= '</div>';
	
	$data['status']	= 1;
	$data['code']	= implode('', $output);

	return json_encode($data);			
}
