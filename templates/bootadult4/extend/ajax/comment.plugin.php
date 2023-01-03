<?php
function ajax_plugin_comment()
{
	$data 	= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	$types	= VData::get('comment_types', 'core');
	if (!isset($_POST['content_id']) or !isset($_POST['comment']) or !isset($_POST['type']) or !isset($_POST['csrf_token'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}
	
	$comment_captcha = VCfg::get('comment_captcha');
	if ($comment_captcha === 1 or $comment_captcha === 2) {
		if (!isset($_POST['captcha'])) {
			$data['msg']	= 'Invalid request (captcha)!';
			return json_encode($data);
		}
	}

	$filter		= VF::factory('filter');
	$type		= $filter->get('type');
	
	if (!isset($types[$type])) {
		$data['msg']	= 'Invalid request (type: '.$type.')!';
		return json_encode($data);
	}
	
	$spam	= false;
	$time	= time();
	if (VSession::exists('comment_added')) {
		$expire	= (int) (VSession::get('comment_added')+VCfg::get('comment_delay'));
		if ($time < $expire) {
//			$data['msg'] = __('dont-spam');
//			return json_encode($data);
		}
	}
	
	$module			= ($type == 'wall') ? 'profile' : $type;
	$allow_comment 	= VCfg::get($module.'.allow_comment');
	if (!$allow_comment) {
		$data['msg'] = __('comments-disabled');
		return json_encode($data);
	}
		
	if ($allow_comment == '1' && !VAuth::loggedin()) {
		$data['msg'] = __('comments-login', array('<a href="'.BASE_URL.LANG.'/user/login/"><strong>'.__('login').'</strong></a>'));
		return json_encode($data);
	}
		
	$content_id	= $filter->get('content_id', 'INT');
	$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	$parent_id	= (isset($_POST['parent_id'])) ? $filter->get('parent_id', 'INT') : 0;
    $nickname   = (isset($_POST['nickname']) && $_POST['nickname'] != '') ? utf8_trim($filter->get('nickname')) : 'anonymous';
    $captcha	= $filter->get('captcha');
	$comment	= VText::newlines(utf8_trim($filter->get('comment')));
	
	if ($comment == '') {
		$data['msg'] = __('comment-empty');
	} elseif (utf8_strlen($comment) > 500) {
		$data['msg'] = __('comment-length');
	}

	if ($data['msg'] != '') {
		return json_encode($data);
	}
	
	if ($nickname != 'anonymous') {
		// this needs to be fixed
		if (!VValid::alnumspace($nickname)) {
			$data['msg']	= __('nickname-invalid').$nickname;
		} elseif (!VValid::length($nickname, 2, 100)) {
			$data['msg']	= __('nickname-length');
		}
				
		if ($data['msg'] != '') {
			return json_encode($data);
		}		
	}
	
	if ($comment_captcha === 1 or $comment_captcha === 2) {
		if ($captcha) {
			if ($comment_captcha === 2) {
				if (!VRecaptcha::verify($captcha)) {
					$data['msg'] = __('captcha-invalid');
				}
			} else {
				$data['debug'] = VSession::exists('captcha_code').'-'.$captcha;
				if (!VSession::exists('captcha_code') or VSession::get('captcha_code') != $captcha) {
					$data['msg'] = __('captcha-invalid');
				}
			}
		} else {
			$data['msg'] = __('captcha-empty');
		}
	}
			
	if ($data['msg'] != '') {
//		return json_encode($data);
	}
	
	$check	= ($parent_id) ? VCsrf::check('post', 'reply') : VCsrf::check();
	if (!$check) {
		$data['msg']	= 'Invalid request (csrf token)!';
		return json_encode($data);
	}

	$cmodel	= VModel::load('comment', $module);
	$ipv	= VServer::ipv(true);
	
	$spam	= 0;
	if (VCfg::get('spam_filter')) {
		$smodel	= VModel::load('spam', 'core');
		if ($user_id) {
			$spam_comments	= $smodel->getStats($user_id);
		} else {
			$spam_comments	= $smodel->getStats(null, $ipv);
		}
		
		if ($user_id) {
			$umodel			= VModel::load('user', 'user');
			$valid_comments	= $umodel->valid($user_id);
			$same_body		= $cmodel->sameBody($user_id, null, $comment);
		} else {
			$valid_comments	= 0;
			$same_body		= $cmodel->sameBody(null, $ipv, $comment);
		}				
		
		$score		= VF::factory('spam')->getScore($comment, $same_body, $spam_comments, $valid_comments);
		if ($score < 0) {
			$spam	= 1;
			if ($score < VCfg::get('library.spam.drop')) {
				VLog::warning('Comment from user_id: '.$user_id.'/ip: '.inet_ntop($ipv).' on '.$type.':'.$content_id.' has a spam score lower than the default drop score!');
				$data['msg']	= __('dont-spam');
				return json_encode($data);				
			}
		}
	}
	
	if (!$content = $cmodel->content($content_id)) {
		$data['msg'] = 'Invalid request (content)!';
		return json_encode($data);
	}
	
	if (isset($content['allow_comment']) and $content['allow_comment'] == '0') {
		$data['msg']	= __('comment-disabled-user');
		return json_encode($data);
	}
	
	if ($type == 'wall') {
		if (!upref($content['wall_comments'], $content['user_id'], $user_id)) {
			$data['msg'] = __('comment-disabled-user');
			return json_encode($data);
		}
	}
	
	$add_time	= time();
	$status		= (VCfg::get($module.'.approve_comments')) ? 2 : 1;
	$status		= ($type == 'wall' and $content['wall_comments'] == '4') ? 2 : $status;
	
	if ($type == 'video') {
		$content_url	= video_view_url($content['video_id'], $content['slug'], null, $content['premium'], true);
	} elseif ($type == 'photo') {
		$content_url	= BASE_URL.'/photo/'.$content['photo_id'].'/';
	} elseif ($type == 'model') {
		$content_url	= model_url($content['slug'], true);
	} elseif ($type == 'wall') {
		$content_url	= BASE_URL.'/users/'.$content['username'].'/wall/'.$content['wall_id'].'/';
	}

	if (VCfg::get('akismet_enabled')) {
		VF::load('akismet.akismet');
		$akismet	= new Akismet(BASE_URL, VCfg::get('akismet_key'));
		$akismet->setCommentContent($comment);
		$akismet->setPermalink($content_url);
				
		if ($user_id) {
			$akismet->setCommentAuthor(VSession::get('username'));
			$akismet->setCommentAuthorEmail(VSession::get('email'));
		} else {
			$akismet->setCommentAuthor($nickname);
		}
				
		if ($akismet->isCommentSpam()) {
			$spam 	= 1;
			$status	= 0;
		}
	}
	
	if ($comment_id = $cmodel->add(array(
		'parent_id'		=> $parent_id,
		'content_id'	=> $content_id,
		'user_id'		=> $user_id,
		'nickname'		=> $nickname,
		'comment'		=> $comment,
		'spam'			=> $spam,
		'status'		=> $status))) {
		$comodel	= VModel::load($type, $module);
		$comodel->update($content_id, array('total_comments' => 'total_comments+1'));
		
		if (VCfg::get('cache')) {
			$cache		= VF::factory('cache');
			$cache->del($type.'-'.$content_id);
			$args		= array(0 => 'c.'.$type.'_id = ? AND c.parent_id = 0 AND c.status = 1', 1 => 'i', 2 => $content_id);
			$cache->del($type.'-comments-total-'.md5(json_encode($args)));
			$args		= array_merge($args, array(3 => 10, 4 => 'c.comment_id', 5 => 'DESC'));
			$cache->del($type.'-comments-'.md5(json_encode($args)));
		}

		if ($type == 'photo') {
			VModel::load('album', 'photo')->update($content['album_id'], array('total_comments' => 'total_comments+1'));
		}
		
		if ($user_id) {
			$umodel	= VModel::load('user', 'user');
			$umodel->update($user_id, array($module.'_comments' => $module.'_comments+1'), 'user_stats', false);
			
			if (!$spam) {
  				if (VCfg::get('user.points')) {
  					VModel::load('points', 'user')->add($user_id, $type.'-comment-add');
      			}
      			
      			if ($type != 'model' and $content['user_id'] != $user_id) {
      				if ($type == 'wall' and $content['wall_comments'] == '4') {
                  		$search		= array('[SITE_NAME]', '[BASE_URL]', '[USERNAME]', '[MODERATE_URL]', '[NOTIFICATIONS_URL]');
                  		$replace	= array(VCfg::get('site_name'), BASE_URL, $content['username'], BASE_URL.'/user/login/?r=/user/comments/', BASE_URL.'/user/notifications/');
                  		VF::factory('email')->predefined('profile-comment-approve', $content['email'], $search, $replace, 'noreply');
      				} else {
      					$notify	= ($type == 'wall') ? $content['profile_comment'] : $content[$type.'_comment'];
      					if ($notify and VCfg::get('user.notify_comment')) {
                  			$search		= array('[SITE_NAME]', '[BASE_URL]', '[USERNAME]', '[CONTENT_URL]', '[NOTIFICATIONS_URL]');
                  			$replace	= array(VCfg::get('site_name'), BASE_URL, $content['username'], $content_url, BASE_URL.'/user/notifications/');
                  			VF::factory('email')->predefined($type.'-comment', $content['email'], $search, $replace, 'noreply');
                  		}
                  	}
      			}
			}
		}
		
		if ($parent_id) {
			$cmodel->update($parent_id, array('replies' => 'replies+1'));
		}
	} else {
		$data['msg']	= 'Failed to add comment!';
		return json_encode($data);
	}

	$data['status']	= 1;
	
	if ($status === 0 or $status === 2) {
		$data['msg']		= __('comment-post-approve');
		return json_encode($data);
	}
	
	$code		= array();
	$username	= ($user_id) ? VSession::get('username') : $nickname;
	$vote		= VCfg::get($module.'.comment_vote');
	$login		= ($vote == '1' and !$user_id) ? 'login ' : '';
	$element	= ($parent_id) ? 'div' : 'li';
	$width		= ($parent_id) ? 50 : 64;
	
	$code[]	= '<div id="comment-'.$comment_id.'" class="media mb-2" data-id="'.$comment_id.'">';
	
	if ($user_id) {
		$code[] = '<a href="'.BASE_URL.LANG.'/users/'.$username.'/" rel="nofollow">';
	}
	
	$code[]	= '<img src="'.USER_URL.'/'.avatar($user_id).'" alt="'.__('username-avatar', array($username)).'" width="64" class="mr-2 rounded">';
	
	if ($user_id) {
		$code[]	= '</a>';
	}
	
	$code[]	= '<div class="media-body">';
	$code[]	= '<div class="row"><div class="col-auto col-md-8"><h6>';
	
	if ($user_id) {
		$code[]	= '<a href="'.BASE_URL.LANG.'/users/'.$username.'/" rel="nofollow">'.e($username).'</a>';
	} else {
		$code[]	= e($username);
	}
	
	$code[]	= '</h6></div>';
	$code[]	= '<div class="col col-md-4 d-flex justify-content-end">';
    $code[] = '<span id="comment-spam-'.$comment_id.'">';
    $code[] = '<button class="comment-spam btn btn-sm" data-id="'.$comment_id.'" data-parent-id="'.$content_id.'" data-toggle="tooltip" data-placement="top" title="'.__('report-spam').'"><i class="fa fa-flag text-warning"></i></button>';
    $code[]	= '</span>';
	$code[]	= '</div></div>';
	
	$code[]	= '<p class="comment-text">'.nl2br(e($comment)).'</p>';
	$code[]	= '<div class="border-top">';

    if ($vote) {
  		$code[] = '<span class="text-success">0</span>';
  		$code[]	= '<div class="btn-group" role="group">';
  		$code[] = '<button class="'.$login.' comment-like btn btn-sm btn-rate" data-type="'.$type.'" data-id="'.$comment_id.'" data-toggle="tooltip" data-placement="top" title="'.__('vote-up').'"><i class="fa fa-thumbs-up"></i></button>';
  		$code[]	= '<button class="'.$login.' comment-dislike btn btn-sm btn-rate" data-type="'.$type.'" data-id="'.$comment_id.'" data-toggle="tooltip" data-placement="top" title="'.__('vote-down').'"><i class="fa fa-thumbs-down"></i></button>';
  		$code[]	= '</div>';
  		$code[]	= '<small class="comment-vote-response"></small>';
	}
	
	$code[]	= '</div>';
	$code[]	= '</div>';
	
	VSession::set('comment_added', time());
	
	$data['code']	= implode('', $code);
	$data['msg']	= __('comment-post-success');
	
	return json_encode($data);			
}
