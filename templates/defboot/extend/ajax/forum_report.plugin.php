<?php
function ajax_plugin_forum_report()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	$types	= array('topic' => 0, 'post' => 1);
	if (isset($_GET['modal'])) {
		$filter		= VF::factory('filter');
		$post_id	= (isset($_GET['post_id'])) ? $filter->get('post_id', 'INT', 'GET') : 0;
		$type		= (isset($_GET['type'])) ? $filter->get('type', 'STRING', 'GET') : null;
		
		if (!$post_id) {
			$data['msg']	= 'Invalid request (post)!';
			return json_encode($data);
		}

		if (!$type or !isset($types[$type])) {
			$data['msg']	= 'Invalid request (type)!';
			return json_encode($data);
		}

		VLanguage::load('frontend.forum');
	
		$code   = array();
        $code[] = '<div id="report-modal" class="modal fade">';
        $code[] = '<div class="modal-dialog modal-sm">';
        $code[] = '<div class="modal-content">';
        $code[] = '<div class="modal-header">';
        $code[] = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.__('close').'</span></button>';
        $code[] = '<h4 class="modal-title">'.__('flag-forum-post').'</h4>';
        $code[] = '</div>';
        $code[] = '<div class="modal-body">';
        $code[]	= '<div id="report-response" class="alert" style="display: none;"></div>';
        $code[] = '<div class="form-group">';
        $code[] = '<label for="reason">'.__('reason').'</label>';
        
        $reasons	= VData::get('reasons', 'forum');
        foreach ($reasons as $reason_id => $name) {
      		$code[]	= '<div class="radio"><input name="reason" type="radio" value="'.$reason_id.'"> <label>'.e($name).'</label></div>';
        }
        
        $code[] = '</div>';
        $code[] = '<div class="form-group">';
        $code[] = '<label for="message">'.__('message').'</label>';
        $code[] = '<textarea name="message" id="message" class="form-control"></textarea>';
        $code[] = '</div>';
        $code[]	= '<div class="modal-footer">';
        $code[] = '<button type="button" id="flag-send" class="btn btn-submit" data-id="'.$post_id.'" data-type="'.$type.'">'.__('submit').'</button>';
        $code[]	= '<button type="button" class="btn btn-menu" data-dismiss="modal">'.__('close').'</button>';
        $code[] = '</div>';
        $code[] = '</div>';
        $code[] = '</div>';
		
		return implode('', $code);
	} else {
		if (!isset($_POST['post_id']) or !isset($_POST['type'])) {
			$data['msg']	= 'Invalid request!';
			return json_encode($data);
		}
		
		$filter		= VF::factory('filter');
		$reasons	= VData::get('reasons', 'forum');
		$reason		= (isset($_POST['reason'])) ? $filter->get('reason', 'INT') : 0;
		
		if ($reason === 0) {
			$data['msg']	= __('flag-empty');
			return json_encode($data);
		}

		if (!isset($reasons[$reason])) {
			$data['msg']	= 'Invalid request (request)!';
			return json_encode($data);
		}

		$type		= $filter->get('type', 'STRING');
		$post_id	= $filter->get('post_id', 'INT');
		$message	= (isset($_POST['message'])) ? $filter->get('message') : '';
		$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
		$ip			= VServer::ipv(true);
		
		if (!isset($types[$type])) {
			$data['msg']	= 'Invalid request (type)!';
			return json_encode($data);
		}
		
		$type_id	= $types[$type];
		$fmodel		= VModel::load('flag', 'forum');
		if ($fmodel->already($type_id, $post_id, $user_id, $ip)) {
			$data['msg']	= __('flag-already');
			return json_encode($data);
		}
		
		$fmodel->add(array(
			'type'		=> $type_id,
			'post_id'	=> $post_id,
			'user_id'	=> $user_id,
			'reason_id'	=> $reason,
			'message'	=> $message,
			'ip'		=> $ip,
			'flag_time'	=> time()
		));
		
		if ($type === 0) {
			$pmodel	= VModel::load('topic', 'forum');
		} else {
			$pmodel	= VModel::load('post', 'forum');
		}
		
		$pmodel->update($post_id, array('flagged' => 'flagged+1', 'flag_time' => time()));
		
		$data['status']	= 1;
		$data['msg']	= __('flag-success');
		
		// we send emails here
		
		return json_encode($data);
	}
}
