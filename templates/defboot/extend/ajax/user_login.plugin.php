<?php
function ajax_plugin_user_login()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');

    $cookie = false;
    $url    = false;
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $filter     = VF::factory('filter');
        $username   = $filter->get('username');
        $password   = trim($_POST['password']);
        $remember   = (isset($_POST['remember'])) ? (int) trim($_POST['remember']) : 0;
    }

    if (isset($username) && isset($password) && isset($remember)) {
        if ($username == '' or $password == '') {
            $data['msg'] = __('login-empty');
            return json_encode($data);
        }

        VHelper::load('user.login');
        $ret = VHelper_user_login::login($username, $password, $remember, $cookie);
        if ($ret === true) {
            $data['msg']    = __('login-success');
            $data['status'] = 1;
        } else {
            $data['msg']    = $ret;
        }

        return json_encode($data);
    } else {
  		VLanguage::load('frontend.user');
  		
        $output     = array();
        $output[]   = '<div id="login-modal" class="modal fade">';
        $output[]   = '<div class="modal-dialog">';
        $output[]   = '<div class="modal-content">';
        $output[]   = '<div class="modal-header">';
        $output[]   = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.__('close').'</span></button>';
        $output[]   = '<h4 class="modal-title">'.__('login-title').'</h4>';
        $output[]   = '</div>';
        $output[]   = '<div class="modal-body">';
        $output[]   = '<input name="url" type="hidden" value="'.CUR_URL.'">';
        $output[]   = '<div id="response-login" class="alert alert-danger" style="display: none;"></div>';
        $output[]   = '<div class="row">';
        $output[]   = '<div class="col-xs-12 col-sm-6 col-md-6 pull-right">';
        $output[]   = '<div class="panel panel-default">';
        $output[]   = '<div class="panel-heading">';
        $output[]   = '<h3 class="panel-title">'.__('signup-reason-title').'</h3>';
        $output[]   = '</div>';
        $output[]   = '<div class="panel-body">';
        $output[]   = '<ul class="nav nav-stacked list-features">';
        $output[]   = '<li><i class="fa fa-check-square"></i> '.__('signup-reason-1').'</li>';
        $output[]   = '<li><i class="fa fa-check-square"></i> '.__('signup-reason-2').'</li>';
        $output[]   = '<li><i class="fa fa-check-square"></i> '.__('signup-reason-3').'</li>';
        $output[]   = '<li><i class="fa fa-check-square"></i> '.__('signup-reason-4').'</li>';
        $output[]   = '<li><i class="fa fa-check-square"></i> '.__('signup-reason-5').'</li>';
        $output[]   = '</ul>';
        $output[]	= '<h5 class="text-center">'.__('signup-reason-join', array('<a href="'.BASE_URL.'/user/signup/" class="btn-color"><strong>'.__('signup-now').'</strong></a>', VCfg::get('site_name'))).'</h5>';
        $output[]   = '</div>';
        $output[]   = '</div>';
        $output[]   = '</div>';
        $output[]   = '<div class="col-xs-12 col-sm-6 col-md-6 pull-right">';
        $output[]   = '<form method="post">';
        $output[]   = '<div class="form-group">';
        $output[]   = '<label for="username">'.__('username').'</label>';
        $output[]   = '<input name="username" type="text" id="username" class="form-control">';
        $output[]   = '</div>';
        $output[]   = '<div class="form-group">';
        $output[]   = '<label for="password">'.__('password').'</label>';
        $output[]   = '<input name="password" type="password" id="password" class="form-control">';
        $output[]   = '</div>';
        $output[]   = '<div class="checkbox"><input name="remember" type="checkbox" value="1"> <label>'.__('remember-me-on-this-computer').'</label></div>';
        $output[]	= '<div class="form-group">';
        $output[]   = '<div class="checkbox">';
        $output[]   = '<a href="'.REL_URL.'/user/lost/" class="btn-xs btn-link">'.__('lost-question').'</a><br>';
        $output[]   = '<a href="'.REL_URL.'/user/lost/" class="btn-xs btn-link">'.__('confirm-question').'</a>';
        $output[]   = '</div>';
        $output[]	= '</div>';
        $output[]   = '</form>';
        $output[]   = '</div>';
        $output[]   = '</div>';
        $output[]   = '</div>';
        $output[]   = '<div class="modal-footer">';
        $output[]   = '<button id="login-submit" type="button" class="btn btn-submit btn-block">'.__('login').'</button>';
        $output[]   = '</div>';
        $output[]   = '</div></div></div>';

        return implode('', $output);
    }   

	return json_encode($data);			
}
