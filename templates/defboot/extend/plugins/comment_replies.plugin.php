<?php
function template_plugin_comment_replies($parent_id, $content_id, $type = 'video')
{
	$types	= VData::get('comment_types', 'core');
	if (!isset($types[$type])) {
		throw new VException('Invalid type!');
	}
	
	$module		= ($type == 'wall') ? 'profile' : $type;
	$cmodel		= VModel::load('comment', $module);
	$where		= 'c.'.$type.'_id= ? AND c.parent_id = ? AND c.status = 1';
	if (!$comments = $cmodel->comments($where, 'ii', array($content_id, $parent_id), 100, 'c.comment_id', 'ASC')) {
		return;
	}
	
	$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	$start		= VCfg::get($module.'.replies_start');
	$vote		= VCfg::get($module.'.comment_vote');
	$login		= ($vote == '1' and !$user_id) ? 'login ' : '';
	$output		= array();
	
	foreach ($comments as $index => $comment) {
		$comment_id	= $comment['comment_id'];
		$username 	= ($comment['user_id']) ? e($comment['username']) : e($comment['nickname']); $url = REL_URL.LANG.'/users/'.$username.'/';
        $status 	= (isset($comment['status'])) ? $comment['status'] : null;
        $display	= (isset($status)) ? '' : ' style="display: none;"';
		
		if ($index == $start) {
        	$output[]   = '<button class="comment-replies-load btn btn-color" data-id="'.$parent_id.'"><strong>'.__('view-all-replies').' ('.count($comments).')</strong></button>';
            $output[]   = '<div id="comment-replies-'.$parent_id.'" style="display: none;">';		
		}
		
		$output[]	= '<div id="comment-'.$comment_id.'" data-id="'.$comment_id.'" class="media">';
    	$output[]	= '<div class="media-left">';
        $output[]	= '<a href="'.$url.'" rel="nofollow">';
        $output[]	= '<img src="'.USER_URL.'/'.avatar(false, $comment['user_id'], $comment['avatar'], $comment['gender']).'" alt="'.__('username-avatar', array($username)).'" width="50" class="media-object">';
        $output[]	= '</a>';
    	$output[]	= '</div>';
    	$output[]	= '<div class="media-body">';
        $output[]	= '<div class="media-heading">';
        
        if ($comment['user_id']) {
      		$output[]	= '<h4 class="pull-left"><a href="'.$url.'" rel="nofollow">'.$username.'</a></h4>';
        } else {
        	$output[]	= '<h4 class="pull-left">'.$username.'</h4>';
        }
        
        $output[]	= '<small><i class="fa fa-clock-o"></i> '.VDate::nice($comment['add_time']).'</small>';
        $output[]	= '<div class="media-buttons pull-right"'.$display.'>';
        
        if ($status == '0') {
            $output[]	= '<button class="comment-approve btn btn-ns btn-success" data-id="'.$comment_id.'">'.__('approve').'</button>';
        }
        
        if (($comment['user_id'] == $user_id) or VAuth::group('Moderator')) {
            $output[]	= '<button class="comment-delete btn btn-ns btn-danger" data-id="'.$comment_id.'">'.__('delete').'</button>';
        }
        
        $output[]	= '<span id="comment-spam-'.$comment_id.'">';
        $output[]	= '<button class="comment-spam btn btn-ns btn-warning" data-id="'.$comment_id.'" data-cotent-id="'.$content_id.'" data-type="'.$type.'">'.__('spam').'</button>';
        $output[]	= '</span>';
        $output[]	= '</div>';
        $output[]	= '<div class="clearfix"></div>';
        $output[]	= '</div>';
        $output[]	= '<p>'.nl2br(e($comment['comment'])).'</p>';
       
        if ($vote) {
      		$output[]	= '<div id="comment-footer-'.$comment_id.'" class="media-footer">';
        	$output[]	= '<span class="text-success">'.$comment['likes'].'</span>';
        	$output[]	= '<button class="'.$login.'comment-rate btn btn-rate" data-vote="up" data-type="'.$type.'" data-id="'.$comment_id.'" data-toggle="tooltip" data-placement="top" title="'.__('vote-up').'"><i class="fa fa-thumbs-up"></i></button>';
        	$output[]	= '<button class="'.$login.'comment-rate btn btn-rate" data-vote="down" data-type="'.$type.'" data-id="'.$comment_id.'" data-toggle="tooltip" data-placement="top" title="'.__('vote-down').'"><i class="fa fa-thumbs-down"></i></button>';
        	$output[]	= '<small class="comment-vote-response"></small>';
      		$output[]	= '</div>';
        }
        
    	$output[]	= '</div>';
		$output[]	= '</div>';
	}
	
    if ($index == $start) {
        $output[]   = '</div>';
    }

    return implode("\n", $output);	
}
?>
