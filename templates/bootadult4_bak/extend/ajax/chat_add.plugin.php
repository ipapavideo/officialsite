<?php
function ajax_plugin_chat_add()
{
	$data 		= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	if (VSession::exists('spammer')) {
		return;
	}
	
	if (!isset($_POST['receiver_id']) or !$_POST['receiver_id'] or
	    !isset($_POST['message']) or !$_POST['message']) {
	    $data['msg']	= 'Invalid request!';
	    return json_encode($data);
	}

	$sender_id		= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	if (!$sender_id) {
	    $data['msg']	= 'Invalid request (sender)!';
	    return json_encode($data);
	}
	
	VLanguage::load('frontend.message');
	
	$filter			= VF::factory('filter');
	$receiver_id	= $filter->get('receiver_id', 'INT');
	$message		= VText::newlines(utf8_trim($filter->get('message')));
	
	$bmodel			= VModel::load('block', 'profile');
	if ($blocked = $bmodel->exists($receiver_id, $sender_id) and $blocked == '1') {
		$data['msg']	= __('chat-blocked');
		return json_encode($data);
	}

	$umodel		= VModel::load('user', 'user');
	$spam		= 0;
	if (VCfg::get('message.spam_filter')) {
		$checks_needed	= VCfg::get('message.spam_filter_msgs');
		$checks_key		= 'checks_done_'.$receiver_id;
		$checks_done	= (VSession::exists($checks_key)) ? (int) VSession::get($checks_key) : 0;
		if ($checks_done <= $checks_needed) {
      		$smodel 		= VModel::load('spam', 'core');
      		$spam_messages	= $smodel->getStats($sender_id, null, 'messages');
//            $valid_messages = $umodel->valid($sender_id, 'message');
			$valid_messages	= 0;
      		$same_body		= 0; // messages with teh same body are more than possible
      		
      		$score      	= VF::factory('spam')->getScore($message, $same_body, $spam_messages, $valid_messages);
      		if ($score < 0) {
          		$spam   = 1;
              	$smodel->addStatsUser($sender_id, 'messages');
          		VLog::error('Message from user_id: '.$sender_id.' to '.$receiver_id.' has a spam score of '.$score.'!');

				$msg_id	= time().mt_rand();

				$code		= array();
				$code[]		= '<div id="message-'.$msg_id.'" class="media p-1" data-id="'.$msg_id.'">';
				$code[]		= '<i class="fa fa-arrow-up"></i>';
	  			$code[]		= '<div class="media-body ml-1">';
	  			$code[]		= '<h6>'.VSession::get('username').' <small class="text-muted">'.__('now').'</small></h6>';
				$code[]		= '<p>NOT SENT: '.nl2br(e($message['message'])).'</p>';
				$code[]		= '</div></div>';
	
				$data['status']	= 1;
				$data['code']	= implode('', $code);

              	return json_encode($data);
      		}

			VSession::set($checks_key, $checks_done+1);
		}
	}
	
	$mmodel			= VModel::load('message', 'message');
	$user			= $mmodel->user('', $receiver_id);
	if (!$msg_id = $mmodel->add(array(
		'sender_id'		=> $sender_id,
		'receiver_id'	=> $receiver_id,
		'spam'			=> $spam,
		'message'		=> $message))) {
		$data['msg']	= 'Invalid request (process)!';
		return json_encode($data);
	}
	
	$umodel->update($sender_id, array('messages' => 'messages+1'), 'user_stats');
	
    $expire = time()-VCfg::get('user.online_expire');
    if ($user['online'] < $expire and $user['new_message'] and !isset($_SESSION['notification_sent'])) {
        $_SESSION['notification_sent'] = 1;
        $search     = array('[#SITE_NAME#]', '[#USERNAME#]', '[#INBOX_URL#]', '[#MESSAGE#]', '[#NOTIFICATIONS_URL#]');
        $replace    = array(VCfg::get('site_name'), VSession::get('username'), BASE_URL.'/message/inbox/', $message, BASE_URL.'/user/notifications/');
        VF::factory('email')->predefined('message', $user['email'], $search, $replace, 'noreply');
    }	
			
	$code	= array();
	$code[]	= '<div id="message-'.$msg_id.'" class="media" data-id="'.$msg_id.'">';
	$code[]	= '<i class="fa fa-arrow-up"></i>';
	$code[]	= '<div class="media-body ml-1">';
	$code[]	= '<h6>'.VSession::get('username').' <small>'.__('right-now').' <button class="btn btn-ns btn-delete" data-id="'.$msg_id.'" msg-sender="'.$sender_id.'"><i class="fa fa-close text-danger"></i></button></small></h6>';
	$code[]	= '<p>'.nl2br(e($message)).'</p>';
	$code[]	= '</div></div>';
	
	$data['status']	= 1;
	$data['code']	= implode('', $code);
	
	return json_encode($data);
}
