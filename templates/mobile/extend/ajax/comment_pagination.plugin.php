<?php
function ajax_plugin_comment_pagination()
{
	$data 	= array('status' => 0, 'code' => '', 'end' => 0, 'page' => 2, 'msg' => '', 'debug' => '');
	$types	= VData::get('comment_types', 'core');
	if (!isset($_POST['content_id']) or !isset($_POST['page']) or !isset($_POST['type'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}

	$filter		= VF::factory('filter');
	$type		= $filter->get('type');
	
	if (!isset($types[$type])) {
		$data['msg']	= 'Invalid request (type)!';
		return json_encode($data);
	}
	
	$module			= ($type == 'wall') ? 'profile' : $type;
	if (!VCfg::get($module.'.comments')) {
		$data['msg']	= __('comments-disabled');
		return json_encode($data);
	}

	$content_id		= $filter->get('content_id', 'INT');
	$user_id		= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	$cmodel			= VModel::load('comment', $module);
	if (!$content_id or !$content = $cmodel->content($content_id)) {
		$data['msg']	= 'Invalid request (content)!';
		return json_encode($data);
	}
	
	$post_reply		= false;
	$allow_comment	= VCfg::get($module.'.allow_comment');
	$callow_comment	= (isset($content['allow_comment'])) ? $content['allow_comment'] : true;
	if ($callow_comment and(($allow_comment === '1' and $user_id) or $allow_comment == '2')) {
		$post_reply	= true;
	}
	
	$replies	= VCfg::get($module.'.comment_replies');
	$start		= VCfg::get($module.'.replies_start');
	$page		= $filter->get('page', 'INT');
	$page		= ($page >= 2) ? $page-1 : $page;
	$perpage	= VCfg::get($module.'.comments_per_page');
	$limit		= ($page*$perpage).', '.($perpage+1);
	$comments	= $cmodel->comments('c.'.$type.'_id = ? AND c.parent_id = 0 AND c.status = 1', 'i', $content_id, $limit);
	if (!$comments) {
		$data['msg']	= __('no-comments');
		return json_encode($data);
	} 
	
	$vote		= VCfg::get($module.'.comment_vote');
	$login		= ($vote == '1' && !$user_id) ? 'login ' : '';
	$code		= array();
	$index		= 0;
	foreach ($comments as $comment) {
		if ($index > 9) {
			break;
		}
	
		$username 	= ($comment['user_id']) ? e($comment['username']) : e($comment['nickname']); $url = REL_URL.LANG.'/users/'.$username.'/';
		$status 	= (isset($comment['status'])) ? $comment['status'] : null; 
		$display	= (!isset($status)) ? ' style="display: none;"' : '';

  		$code[]	= '<li id="comment-'.$comment['comment_id'].'" data-id="'.$comment['comment_id'].'" class="media">';
    	$code[]	= '<div class="media-left">';
        $code[]	= '<a href="'.$url.'" rel="nofollow">';
        $code[]	= '<img src="'.USER_URL.'/'.avatar(false, $comment['user_id'], $comment['avatar'], $comment['gender']).'" alt="'.__('username-avatar', array($username)).'" width="64" class="media-object">';
        $code[]	= '</a></div>';
    	$code[]	= '<div class="media-body">';
        $code[]	= '<div class="media-heading">';
        
        if ($comment['user_id']) {
          $code[]	= '<h4 class="pull-left"><a href="'.$url.'" rel="nofollow">'.$username.'</a></h4>';
        } else {
          $code[]	= '<h4 class="pull-left">'.$username.'</h4>';
        }
        
        $code[]	= '<small><i class="fa fa-clock-o"></i> '.VDate::nice($comment['add_time']).'</small>';
        $code[]	= '<div class="media-buttons pull-right"'.$display.'>';
        
        if ($status == '0') {
            $code[]	= '<button class="comment-approve btn btn-ns btn-success" data-id="'.$comment['comment_id'].'" data-toggle="tooltip" data-placement="top" title="'.__('approve-comment').'">'.__('approve').'</button> ';
        }
        
        if (($comment['user_id'] == $user_id) or VAuth::group('Moderator', true)) {
            $code[]	= '<button class="comment-delete btn btn-ns btn-danger" data-id="'.$comment['comment_id'].'" data-toggle="tooltip" data-placement="top" title="'.__('delete-comment').'">'.__('delete').'</button> ';
        }

        $code[]	= '<span id="comment-spam-'.$comment['comment_id'].'">';
        $code[]	= '<button class="comment-spam btn btn-ns btn-warning" data-id="'.$comment['comment_id'].'" data-content-id="'.$content_id.'" data-type="'.$type.'" data-toggle="tooltip" data-placement="top" title="'.__('report-spam').'">'.__('spam').'</button>';
        $code[]	= '</span></div><div class="clearfix"></div></div>';
        $code[]	= '<p>'.nl2br(e($comment['comment'])).'</p>';
        $code[]	= '<div id="comment-footer-'.$comment['comment_id'].'" class="media-footer">';
        
        if ($vote) {
      		$code[]	= '<span class="text-success">'.$comment['likes'].'</span>';
        	$code[]	= '<button class="'.$login.'comment-rate comment-rate-up btn btn-rate" data-vote="up" data-type="'.$type.'" data-id="'.$comment['comment_id'].'" data-toggle="tooltip" data-placement="top" title="'.__('vote-up').'"><i class="fa fa-thumbs-up"></i></button>';
        	$code[]	= '<button class="'.$login.'comment-rate comment-rate-down btn btn-rate" data-vote="down" data-type="'.$type.'" data-id="'.$comment['comment_id'].'" data-toggle="tooltip" data-placement="top" title="'.__('vote-down').'"><i class="fa fa-thumbs-down"></i></button>';
        }
        
        if ($replies and $allow_comment) {
      		$code[]	= '<button class="comment-reply btn btn-xs btn-reply" data-id="'.$comment['comment_id'].'" data-type="'.$type.'" data-content-id="'.$content_id.'">'.__('reply').'</button>';
      	}
        
        $code[]	= '<small class="comment-vote-response"></small>';
        $code[]	= '</div>';
        
        if (isset($comment['replies'])) {
      		$display	= ($comment['replies'] == '0') ? ' style="display: none;"' : '';
      		$code[]		= '<div id="comment-replies-container-'.$comment['comment_id'].'" class="comment-replies-container media"'.$display.'>';
      		
      		if ($comment['replies'] > 0) {
      			$code[]	= ajax_plugin_comment_pagination_replies($comment['comment_id'], $type, $user_id, $start, $vote, $login, $cmodel);
      		}
      		
      		$code[]		= '</div>';
      	}
      
    	$code[]	= '</div></li>';
    	++$index;
	}
	
	$data['status']	= 1;
	$data['code']	= implode('', $code);
	$data['page']	= $page+1;
	
	if (count($comments) < 11) {
		$data['end']	= 1;
	}
  
	return json_encode($data);			
}

function ajax_plugin_comment_pagination_replies($parent_id, $type, $user_id, $start, $vote, $login, $cmodel)
{
	$where      = 'c.parent_id = ? AND c.status = 1';
    if (!$comments = $cmodel->comments($where, 'i', $parent_id, 100, 'c.comment_id', 'ASC')) {
        return;
    }
    
    $output		= array();
    foreach ($comments as $index => $comment) {
        $comment_id = $comment['comment_id'];
        $username   = ($comment['user_id']) ? e($comment['username']) : e($comment['nickname']); $url = REL_URL.LANG.'/users/'.$username.'/';
        $status     = (isset($comment['status'])) ? $comment['status'] : null;
        $display    = (isset($status)) ? ' style="display: none;"' : '';

        if ($index == $start) {
            $output[]   = '<button class="comment-replies-load btn btn-color" data-id="'.$parent_id.'"><strong>'.__('view-all-replies').' ('.count($comments).')</strong></button>';
            $output[]   = '<div id="comment-replies-'.$parent_id.'" style="display: none;">';
        }

        $output[]   = '<div id="comment-'.$comment_id.'" data-id="'.$comment_id.'" class="media">';
        $output[]   = '<div class="media-left">';
        $output[]   = '<a href="'.$url.'" rel="nofollow">';
        $output[]   = '<img src="'.USER_URL.'/'.avatar(false, $comment['user_id'], $comment['avatar'], $comment['gender']).'" alt="'.__('username-avatar', array($username)).'" width="50" class="media-object">';
        $output[]   = '</a>';
        $output[]   = '</div>';
        $output[]   = '<div class="media-body">';
        $output[]   = '<div class="media-heading">';

        if ($comment['user_id']) {
            $output[]   = '<h4 class="pull-left"><a href="'.$url.'" rel="nofollow">'.$username.'</a></h4>';
        } else {
            $output[]   = '<h4 class="pull-left">'.$username.'</h4>';
        }
        
        $output[]   = '<small><i class="fa fa-clock-o"></i> '.VDate::nice($comment['add_time']).'</small>';
        $output[]   = '<div class="media-buttons pull-right"'.$display.'>';

        if ($status == '0') {
            $output[]   = '<button class="comment-approve btn btn-ns btn-success" data-id="'.$comment_id.'">'.__('approve').'</button> ';
        }

        if (($comment['user_id'] == $user_id) or VAuth::group('Moderator', true)) {
            $output[]   = '<button class="comment-delete btn btn-ns btn-danger" data-id="'.$comment_id.'">'.__('delete').'</button> ';
        }
        
        $output[]   = '<span id="comment-spam-'.$comment_id.'">';
        $output[]   = '<button class="comment-spam btn btn-ns btn-warning" data-id="'.$comment_id.'" data-parent-id="">'.__('spam').'</button>';
        $output[]   = '</span></div><div class="clearfix"></div></div>';
        $output[]   = '<p>'.nl2br(e($comment['comment'])).'</p>';

        if ($vote) {
            $output[]   = '<div id="comment-footer-'.$comment_id.'" class="media-footer">';
            $output[]   = '<span class="text-success">'.$comment['likes'].'</span>';
            $output[]   = '<button class="'.$login.'comment-like btn btn-rate" data-type="'.$type.'" data-id="'.$comment_id.'" data-toggle="tooltip" data-placement="top" title="'.__('vote-up').'"><i class="fa fa-thumbs-up"></i></button>';
            $output[]   = '<button class="'.$login.'comment-dislike btn btn-rate" data-type="'.$type.'" data-id="'.$comment_id.'" data-toggle="tooltip" data-placement="top" title="'.__('vote-down').'"><i class="fa fa-thumbs-down"></i></button>';
            $output[]   = '<small class="comment-vote-response"></small>';
            $output[]   = '</div>';
        }

        $output[]   = '</div>';
        $output[]   = '</div>';
    }
        
    if ($index == $start) {
        $output[]   = '</div>';
    }
        
    return implode('', $output);
}
?>
