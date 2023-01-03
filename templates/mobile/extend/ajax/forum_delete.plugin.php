<?php
function ajax_plugin_forum_delete()
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
	
		$msg	= ($type == 'topic') ? __('topic-delete-question') : __('post-delete-question');
		$code   = array();
        $code[] = '<div id="delete-modal" class="modal fade">';
        $code[] = '<div class="modal-dialog modal-sm">';
        $code[] = '<div class="modal-content">';
        $code[] = '<div class="modal-header">';
        $code[] = '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.__('close').'</span></button>';
        $code[] = '<h4 class="modal-title">'.__('delete-forum-post').'</h4>';
        $code[] = '</div>';
        $code[] = '<div class="modal-body">';
        $code[]	= '<div id="delete-response" class="alert" style="display: none;"></div>';
        $code[]	= '<div class="none">'.$msg.'</div>';
        $code[]	= '<div class="modal-footer">';
        $code[] = '<button type="button" id="forum-delete" class="btn btn-submit" data-id="'.$post_id.'" data-type="'.$type.'">'.__('yes').'</button>';
        $code[]	= '<button type="button" class="btn btn-menu" data-dismiss="modal">'.__('no').'</button>';
        $code[] = '</div>';
        $code[] = '</div>';
        $code[] = '</div>';
		
		return implode('', $code);
	} else {
		if (!isset($_POST['post_id']) or !isset($_POST['type'])) {
			$data['msg']	= 'Invalid request!';
			return json_encode($data);
		}
		
		$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
		$moderator	= ($user_id and VAcl::perm('forum-moderate')) ? true : false;
		
		if (!$user_id and !$moderator) {
			$data['msg']	= 'Invalid request (login)!';
			return json_encode($data);
		}

		$filter		= VF::factory('filter');
		$type		= $filter->get('type', 'STRING');
		$post_id	= $filter->get('post_id', 'INT');
		$ip			= VServer::ipv(true);
		
		if (!isset($types[$type])) {
			$data['msg']	= 'Invalid request (type)!';
			return json_encode($data);
		}
		
		$tmodel		= VModel::load('topic', 'forum', true);
		$pmodel		= VModel::load('post', 'forum', true);
		
		if ($type == 'topic') {
			if (!VCfg::get('forum.allow_delete')) {
				$data['msg']	= 'Invalid request (disabled)!';
				return json_encode($data);
			}			
		
			$post	= $tmodel->get($post_id, array('ft.user_id', 'f.slug'));
		} elseif ($type == 'post') {
			$post 	= $pmodel->get($post_id, array('fp.user_id'));
		}
	  
		if (!$post) {			
			$data['msg']	= 'Invalid request (post_id)!';
			return false;
		}
		
		if (!$moderator and $post['user_id'] != $user_id) {
			$data['msg']	= 'Invalid request (user_id)!';
			return false;
		}

		VLanguage::load('frontend.forum');
		
		if ($type == 'topic') {
			$method			= VCfg::get('forum.delete_method');
			if ($method == 'delete') {
				$tmodel->del($post_id);
			} elseif ($method == 'suspend') {
				$tmodel->update($post_id, array('status' => 0), false);
			} elseif ($method == 'change') {
				$username	= VCfg::get('forum.delete_username');
				$umodel		= VModel::load('user', 'user');
				if (!$new_user_id = $umodel->exists('username', $username)) {
					$data['msg']	= 'Invalid request (username)!';
					return json_encode($data);
				}
				
				$umodel->update($post['user_id'], array('topics' => 'topics-1'), 'user_stats');
				$umodel->update($new_user_id, array('topics' => 'topics+1'), 'user_stats');
				$tmodel->update($post_id, array('user_id' => $new_user_id));
			}
		
			VMsg::success(__('forum-topic-del-success'), true);
			$data['code']	= BASE_URL.'/forum/'.e($post['slug']).'/';
		} elseif ($type == 'post') {
			$data['msg']	= __('forum-post-del-success');
			$pmodel->del($post_id);
		}
		
		$data['status']	= 1;
				
		return json_encode($data);
	}
}
