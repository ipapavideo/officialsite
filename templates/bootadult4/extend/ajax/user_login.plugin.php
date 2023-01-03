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
        $output[]   = '<div class="modal-dialog modal-sm">';
        $output[]   = '<div class="modal-content">';
        $output[]   = '<div class="modal-header">';
        $output[]   = '<h4 class="modal-title">'.__('login-title').'</h4>';
        $output[]   = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>';
        $output[]   = '</div>';
        $output[]   = '<div class="modal-body">';
        $output[]   = '<input name="url" type="hidden" value="'.CUR_URL.'">';
        $output[]   = '<div id="response-login" class="alert alert-danger" style="display: none;"></div>';

        $output[]	= '<div class="row">';

        $output[]	= '<div class="col">';
        $output[]	= '<div class="text-center mt-2 mb-2">'.__('signup-reason-join', array('<a href="'.BASE_URL.'/user/signup/" class="btn-color"><strong>'.__('signup-now').'</strong></a>', VCfg::get('site_name'))).'</div>';
        $output[]   = '<form method="post">';

        $output[]   = '<div class="form-group">';
        $output[]   = '<label for="m_username" class="col-form-label">'.__('username').'</label>';
        $output[]   = '<input name="m_username" type="text" id="m_username" class="form-control">';
        $output[]   = '</div>';

        $output[]   = '<div class="form-group">';
        $output[]   = '<label for="m_password" class="col-form-label">'.__('password').'</label>';
        $output[]   = '<input name="m_password" type="password" id="m_password" class="form-control">';
        $output[]   = '</div>';

        $output[]	= '<div class="custom-control custom-checkbox">';
        $output[]	= '<input name="m_remember" type="checkbox" class="custom-control-input" id="remember" value="1">';
        $output[]	= '<label class="custom-control-label" for="remember">'.__('remember-me-on-this-computer').'</label>';
        $output[]	= '</div>';

        $output[]	= '<div class="form-group">';
        $output[]   = '<a href="'.REL_URL.LANG.'/user/lost/" class="btn-xs btn-link">'.__('lost-question').'</a><br>';
        $output[]   = '<a href="'.REL_URL.LANG.'/user/lost/" class="btn-xs btn-link">'.__('confirm-question').'</a>';
        $output[]	= '</div>';

        $output[]   = '</form>';

        $output[]	= '</div>';
        
        $output[]   = '</div>';
        $output[]   = '<div class="modal-footer">';
        $output[]   = '<button id="login-submit" type="button" class="btn btn-submit btn-primary btn-block">'.__('login').'</button><br>';
        $output[]	= '<a href="'.REL_URL.LANG.'/user/signup/" class="btn btn-submit-alt btn-primary btn-block">'.__('sign-up').'</a>';
        $output[]   = '</div>';
        $output[]   = '</div></div></div>';
        
        return implode('', $output);
    }   

	return json_encode($data);			
}
