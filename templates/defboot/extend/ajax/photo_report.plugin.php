<?php
function ajax_plugin_photo_report()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	if (isset($_GET['modal'])) {
		VLanguage::load('frontend.photo');
	
		$code   = array();
        $code[] = '<div id="report-modal" class="modal fade">';
        $code[] = '<div class="modal-dialog modal-sm">';
        $code[] = '<div class="modal-content">';
        $code[] = '<div class="modal-header">';
        $code[] = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.__('close').'</span></button>';
        $code[] = '<h4 class="modal-title">'.__('flag-photo').'</h4>';
        $code[] = '</div>';
        $code[] = '<div class="modal-body">';
        $code[] = '<div class="form-group">';
        $code[] = '<label for="reason">'.__('reason').'</label>';
        
        $reasons	= VData::get('reasons', 'photo');
        foreach ($reasons as $reason_id => $name) {
      		$code[]	= '<div class="radio"><input name="reason" type="radio" value="'.$reason_id.'"> <label>'.e($name).'</label></div>';
        }
        
        $code[] = '</div>';
        $code[] = '<div class="form-group">';
        $code[] = '<label for="message">'.__('message').'</label>';
        $code[] = '<textarea name="message" id="message" class="form-control"></textarea>';
        $code[] = '</div>';
        $code[]	= '<div class="modal-footer">';
        $code[] = '<button type="button" id="flag-send" class="btn btn-submit">'.__('submit').'</button>';
        $code[]	= '<button type="button" class="btn btn-submit" data-dismiss="modal">'.__('close').'</button>';
        $code[] = '</div>';
        $code[] = '</div>';
        $code[] = '</div>';
		
		return implode('', $code);
	} else {
		if (!isset($_POST['photo_id'])) {
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

		$photo_id	= $filter->get('photo_id', 'INT');
		$message	= (isset($_POST['message'])) ? $filter->get('message') : '';
		$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
		$ip			= VServer::ipv(true);
		
		$fmodel		= VModel::load('flag', 'photo');
		if ($fmodel->already($photo_id, $ip, $user_id)) {
			$data['msg']	= __('flag-already');
			return json_encode($data);
		}
		
		$fmodel->add(array(
			'photo_id'	=> $photo_id,
			'user_id'	=> $user_id,
			'reason_id'	=> $reason,
			'message'	=> $message,
			'ip'		=> $ip,
			'flag_time'	=> time()
		));
		
		$pmodel	= VModel::load('photo', 'photo');
		$pmodel->update($photo_id, array('flagged' => 1, 'flag_time' => time()));
		
		$data['status']	= 1;
		$data['msg']	= __('flag-success');

        $photo_url  = BASE_URL.'/photo/'.$photo_id.'/';
        $search     = array('[REASON]', '[BASE_URL]', '[SITE_NAME]', '[PHOTO_URL]');
        $replace    = array($reasons[$reason], BASE_URL, VCfg::get('site_name'), $photo_url);
        VF::factory('email')->predefined('photo-report', VCfg::get('email_site'), $search, $replace, 'noreply');

        VLog::warning('Photo '.$photo_url.' was flagged as '.$reasons[$reason].' by user_id: '.$user_id.' from ip: '.inet($ip));
		
		
		return json_encode($data);
	}
}
