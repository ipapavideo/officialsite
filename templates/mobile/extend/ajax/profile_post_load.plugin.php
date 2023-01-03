<?php
function ajax_plugin_profile_post_load()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
	
	if (!isset($_POST['user_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
	}
	
    VLanguage::load('frontend.profile');
    
    $poster_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$poster_id) {
  		$data['msg'] = __('profile-post-login', '<a href="#login" class="login btn btn-color"><strong>'.__('login').'</strong></a>');
  		return json_encode($data);
    }
    
    $filter		= VF::factory('filter');
    $user_id	= $filter->get('user_id', 'INT');    
    $wmodel		= VModel::load('wall', 'profile');    
    $wall 		= $wmodel->wall($user_id);
    $username	= e($wall['username']);
    
    if ($wall['wall'] == '0') {
  		$data['msg']		= __('profile-post-disabled');
    } elseif ($wall['wall'] == '2' and $user_id != $poster_id) {
  		$fmodel = VModel::load('friend', 'profile');
  		if ($fmodel->exists($user_id, $poster_id) != '1') {
  			$data['msg']	= __('profile-post-friend', '<strong>'.e($wall['username']).'</strong>');
  		}
    } elseif ($wall['wall'] == '3') {
  		if ($user_id != $poster_id) {
  			$data['msg']	= __('post-post-self', '<strong>'.e($wall['username']).'</strong>');
  		}
    }
    
    if ($data['msg']) {
  		return json_encode($data);
    }
    
    $code	= array();
    $code[]	= '<div id="profile-editor"></div>';
    $code[]	= '<div class="pull-left"><small><span id="profile-remaining">10000</span> '.__('characters-left').'</small></div>';
    $code[]	= '<div class="pull-right"><button id="wall-submit" class="btn btn-submit">'.__('post').'</button></div>';
    $code[]	= '<div class="clearfix"></div>';
    
    $data['code']	= implode('', $code);
    $data['status']	= 1;
    
	return json_encode($data);
}
