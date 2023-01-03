<?php
function ajax_plugin_profile_post_report()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	if (isset($_POST['modal'])) {
		if (!isset($_POST['wall_id'])) {
			$data['msg']	= 'Invalid request (id)!';
			return json_encode($data);
		}

		$filter		= VF::factory('filter');
		$wall_id	= $filter->get('wall_id', 'INT');
		
		VLanguage::load('frontend.profile');
	
		$code   = array();
        $code[] = '<div id="report-modal" class="modal fade">';
        $code[] = '<div class="modal-dialog modal-sm">';
        $code[] = '<div class="modal-content">';
        $code[] = '<div class="modal-header">';
        $code[] = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.__('close').'</span></button>';
        $code[] = '<h4 class="modal-title">'.__('report-wall-post').'</h4>';
        $code[] = '</div>';
        $code[] = '<div class="modal-body">';
        $code[] = '<div class="form-group">';
        $code[] = '<label for="reason">'.__('reason').'</label>';
        
        $reasons	= VData::get('reasons', 'photo');
        foreach ($reasons as $reason_id => $name) {
      		$code[]	= '<div class="radio"><label><input name="reason" type="radio" value="'.$reason_id.'"> '.e($name).'</label></div>';
        }
        
        $code[] = '</div>';
        $code[] = '<div class="form-group">';
        $code[] = '<label for="message">'.__('message').'</label>';
        $code[] = '<textarea name="message" id="message" class="form-control"></textarea>';
        $code[] = '</div>';
        $code[] = '<button type="button" id="report-send" data-id="'.$wall_id.'" class="btn btn-submit">'.__('submit').'</button>';
        $code[] = '</div>';
        $code[] = '</div>';
        $code[] = '</div>';
        
        $data['code']	= implode('', $code);
        $data['status']	= 1;
		
		return json_encode($data);
	} else {
		if (!isset($_POST['wall_id'])) {
			$data['msg']	= 'Invalid request!';
			return json_encode($data);
		}
		
		$filter		= VF::factory('filter');
		$reasons	= VData::get('reasons', 'photo');
		$reason		= (isset($_POST['reason'])) ? $filter->get('reason', 'INT') : 0;
		
		if ($reason === 0) {
			$data['msg']	= __('flag-empty');
			return json_encode($data);
		}

		if (!isset($reasons[$reason])) {
			$data['msg']	= 'Invalid request (request)!';
			return json_encode($data);
		}

		$wall_id	= $filter->get('wall_id', 'INT');
		$message	= (isset($_POST['message'])) ? $filter->get('message') : '';
		$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
		$ip			= VServer::ipv();
		
		$fmodel		= VModel::load('flag', 'profile');
		if ($fmodel->already($wall_id, $ip, $user_id)) {
			$data['msg']	= __('flag-already');
			return json_encode($data);
		}
		
		$fmodel->add(array(
			'wall_id'	=> $wall_id,
			'user_id'	=> $user_id,
			'reason_id'	=> $reason,
			'message'	=> $message,
			'ip'		=> $ip,
			'flag_time'	=> time()
		));
		
		$wmodel	= VModel::load('wall', 'profile');
		$wmodel->update($wall_id, array('flagged' => 'flagged+1', 'flag_time' => time()));
		
		$data['status']	= 1;
		$data['msg']	= __('flag-success');
		
		return json_encode($data);
	}
}
