<?php
function ajax_plugin_video_flag()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	if (isset($_GET['modal'])) {
		VLanguage::load('frontend.video');

        $code   = array();
        $code[] = '<div id="flag-modal" class="modal fade" tabindex="-1" role="dialog">';
        $code[] = '<div class="modal-dialog modal-sm" role="document">';
        $code[] = '<div class="modal-content">';
        $code[] = '<div class="modal-header">';
        $code[] = '<h4 class="modal-title">'.__('flag-video').'</h4>';
        $code[] = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.__('close').'</span></button>';
        $code[] = '</div>';
        $code[] = '<div class="modal-body">';
        $code[] = '<div class="form-group">';
        $code[] = '<label for="reason">'.__('reason').'</label>';
            
        $reasons    = VData::get('reasons', 'video');
        foreach ($reasons as $reason_id => $name) {
      		$code[]	= '<div class="custom-control custom-radio">';
      		$code[]	= '<input name="reason" type="radio" value="'.$reason_id.'" class="custom-control-input" id="reason-'.$reason_id.'">';
      		$code[]	= '<label class="custom-control-label" for="reason-'.$reason_id.'">'.e($name).'</label>';
      		$code[]	= '</div>';
        }
            
        $code[] = '</div>';
        $code[] = '<div class="form-group">';
        $code[] = '<label for="message">'.__('message').'</label>';
        $code[] = '<textarea name="message" id="message" class="form-control"></textarea>';
        $code[] = '</div>';
        $code[] = '<button type="button" id="flag-send" class="btn btn-primary">'.__('submit').'</button>';
        $code[] = '</div>';
        $code[] = '</div>';
        $code[] = '</div>';
		
		return implode('', $code);
	} else {
		if (!isset($_POST['video_id'])) {
			$data['msg']	= 'Invalid request!';
			return json_encode($data);
		}
		
		$filter		= VF::factory('filter');
		$reasons	= VData::get('reasons', 'video');
		$reason		= (isset($_POST['reason'])) ? $filter->get('reason', 'INT') : 0;
		
		if ($reason === 0) {
			$data['msg']	= __('flag-empty');
			return json_encode($data);
		}

		if (!isset($reasons[$reason])) {
			$data['msg']	= 'Invalid request (request)!';
			return json_encode($data);
		}

		$video_id	= $filter->get('video_id', 'INT');
		$message	= (isset($_POST['message'])) ? $filter->get('message') : '';
		$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
		$ip			= VServer::ipv(true);
		
		$fmodel		= VModel::load('flag', 'video');
		if (!$video = $fmodel->content($video_id)) {
			$data['msg']	= __('missing');
			return json_encode($data);
		}
		
		if ($fmodel->already($video_id, $ip, $user_id)) {
			$data['msg']	= __('flag-already');
			return json_encode($data);
		}
		
		$fmodel->add(array(
			'video_id'	=> $video_id,
			'user_id'	=> $user_id,
			'reason_id'	=> $reason,
			'message'	=> $message,
			'ip'		=> $ip,
			'flag_time'	=> time()
		));
		
		$vmodel	= VModel::load('video', 'video');
		$vmodel->update($video_id, array('flagged' => 1, 'flag_time' => time()));
		
		$video_url	= video_view_url($video_id, $video['slug'], null, $video['premium'], true);
		$search		= array('[REASON]', '[BASE_URL]', '[SITE_NAME]', '[VIDEO_URL]');
		$replace	= array($reasons[$reason], BASE_URL, VCfg::get('site_name'), $video_url);
		VF::factory('email')->predefined('video-report', VCfg::get('email_site'), $search, $replace, 'noreply');
		
		VLog::warning('Video '.$video_url.' was flagged as '.$reasons[$reason].' by user_id: '.$user_id.' from ip: '.inet($ip));
		
		$data['status']	= 1;
		$data['msg']	= __('flag-success');
		
		// we send emails here
		
		return json_encode($data);
	}
}
