<?php
function ajax_plugin_comment_reply()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	$types	= VData::get('comment_types', 'core');
	
	if (!isset($_POST['comment_id']) or !isset($_POST['content_id']) or !isset($_POST['type'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}
	
	$filter		= VF::factory('filter');
	$content_id	= $filter->get('content_id', 'INT');
	$comment_id	= $filter->get('comment_id', 'INT');
	$type		= $filter->get('type');
	
	if (!isset($types[$type])) {
		$data['msg']	= 'Invalid request (type)!';
		return json_encode($data);
	}

	$module			= ($type == 'wall') ? 'profile' : $type;
	$allow_comment	= VCfg::get($module.'.allow_comment');
	if (!$allow_comment) {
		$data['msg']	= __('comments-disabled');
		return json_encode($data);
	}
	
	$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	if ($allow_comment == '1' and !$user_id) {
		$data['msg']	= __('comments-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><strong>'.__('login').'</strong></a>'));
		return json_encode($data);
	}
	
	if (!VCfg::get($module.'.comment_replies')) {
		$data['msg']	= __('comments-replies-disabled');
		return json_encode($data);		
	}

	$token		= VCsrf::generate('reply');
	$output		= array();
	$output[]	= '<div id="comment-reply-container" class="border p-1 mb-2">';
	$output[]	= '<div id="response-comment-reply" class="alert alert-danger" style="display: none;"></div>';
	$output[]	= '<input name="csrf_token_comment_reply" type="hidden" value="'.$token.'">';
	$output[]	= '<div class="row no-gutters">';
    $output[]	= '<div class="col col-auto">';
    $output[]	= '<div style="width: 50px;">';
    $output[]	= '<img src="'.USER_URL.'/'.avatar(true).'" alt="'.__('user-avatar').'" class="rounded" width="50">';
    $output[]	= '</div>';
    $output[]	= '</div>';
    $output[]	= '<div class="col pl-2">';

    if (VCfg::get('honeypot')) {
  		$output[]	= '<input name="comment_field" id="comment-field" type="text" class="form-control form-control-sm d-none" placeholder="Leave this input empty!">';
    }
    
    $output[]	= '<div class="row">';
	if (!$user_id) {
  		$output[]	= '<div class="col-12 col-md-4 mb-1">';
        $output[]	= '<input name="nicknamer" id="nicknamer" type="text" class="form-control form-control-sm" placeholder="'.__('nickname').'">';
        $output[]	= '</div>';			
	}
	
	$output[]	= '<div class="col-12">';
    $output[]	= '<textarea name="commentr" id="commentr" class="form-control form-control-sm elastic" rows="3" placeholder="'.__('comment').'"></textarea>';
    $output[]	= '</div>';
    $output[]	= '</div>';
    
    $output[]	= '<div class="row mt-1">';
    $output[]	= '<div class="col-12 col-md-6">';
    
    $comment_captcha = VCfg::get('comment_captcha');
    if ($comment_captcha === 2 and VCfg::get('recaptcha')) {
        $output[]   = '<div class="g-recaptcha" data-sitekey="'.VCfg::get('recaptcha_site_key').'" id="recaptcha" data-theme="dark"></div>';
    } elseif ($comment_captcha === 1) {
  		$output[]	= '<div class="d-flex justify-content-center justify-content-md-start">';
  		$output[]	= '<img src="'.BASE_URL.'/captcha/?rand='.time().'" id="captcha" class="captcha-reload rounded" alt="" data-toggle="tooltip" data-placement="top" title="'.__('click-to-reload-image').'">';
    	$output[]	= '<input name="captcha-verify-reply" type="text" class="form-control form-control-sm ml-1" style="width: 40px;">';
        $output[]   = '</div>';
    }    
    
    $output[]	= '</div>';
	$output[]	= '<div class="col-12 col-md-6 mt-2 mt-md-0">';
    $output[]   = '<div class="d-flex justify-content-center justify-content-between">';
	$output[]	= '<small><span id="remainingr">500</span>'.__('characters-left').'</small>';
	$output[]	= '<button id="post-comment-reply" class="btn btn-sm btn-primary" data-content-id="'.$content_id.'" data-parent-id="'.$comment_id.'" data-type="'.$type.'">'.__('post-reply').'</button>';
	$output[]	= '</div>';
	$output[]	= '</div>';
    
    $output[]	= '</div>';

    
    $output[]	= '</div>';
    $output[]	= '</div>';

	
	$output[]	= '</div>';
	
	
	$data['status']	= 1;
	$data['code']	= implode('', $output);

	return json_encode($data);			
}
