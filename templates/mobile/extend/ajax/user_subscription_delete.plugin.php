<?php
function ajax_plugin_user_subscription_delete()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.user');
    
    if (!isset($_POST['user_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('subscription-delete-login');
        return json_encode($data);
    }
        
    $filter			= VF::factory('filter');
    $subscriber_id	= $filter->get('user_id', 'INT');
    
    $smodel		= VModel::load('subscribe', 'profile');
    $smodel->del($subscriber_id, $user_id);
    
	$data['msg']	= __('subscription-deleted');
	$data['status']	= 1;
	
	return json_encode($data);	
}
