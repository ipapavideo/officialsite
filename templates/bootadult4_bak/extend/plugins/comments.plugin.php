<?php
function template_plugin_comments($comments, $comments_total, $content_id, $type, $parent_id, $allow_comment, $submenu = '')
{
	$output		= array();
	
	if (!$parent_id) {	
		$output[]	= '<div id="comments-container-'.$content_id.'" class="comments-container mt-2 w-100">';
	}
	
	if (!$comments) {
		$output[]	= '<div class="none none-small">'.__('no-comments').'</div>';
		$output[]	= '</div>';
		
		return implode("\n", $output);
	}

	$loggedin 	= VAuth::loggedin();
	$module		= $type;
	$module		= ($module == 'wall') ? 'profile' : $module;
	$vote		= VCfg::get($module.'.comment_vote');
	$login 		= ($vote == '1' && !$loggedin) ? 'login ' : '';
	$user_id    = ($loggedin) ? (int) VSession::get('user_id') : 0;
	$reply		= VCfg::get($module.'.comment_replies');
	$start		= ($parent_id) ? VCfg::get($module.'.replies_start') : 0;
	$width		= ($parent_id) ? 50 : 64;
	
	foreach ($comments as $index => $comment) {
	  $comment_id	= $comment['comment_id'];
	  $username 	= ($comment['user_id']) ? e($comment['username']) : e($comment['nickname']);
	  $url 			= REL_URL.LANG.'/users/'.$username.'/';
	  $status 		= (isset($comment['status'])) ? $comment['status'] : null;
	  $class		= ($start and $index > $start) ? ' d-none' : '';
	  
	  $output[]		= '<div class="media mb-2'.$class.'" id="comment-'.$comment_id.'" data-id="'.$comment_id.'">';
	  
	  if ($comment['user_id']) {
		  $output[]	= '<a href="'.$url.'" rel="nofollow">';
	  }
	  
	  $output[]		= '<img src="'.USER_URL.'/'.avatar(false, $comment['user_id'], $comment['avatar'], $comment['gender']).'" alt="'.__('username-avatar', array($username)).'" width="'.$width.'" class="mr-2 rounded">';
	  
	  if ($comment['user_id']) {
		  $output[]	= '</a>';
	  }
	  
	  $output[]		= '<div class="media-body">';
      
      $output[]		= '<div class="row">';
      $output[]		= '<div class="col-auto col-md-8">';
      $output[]		= '<h6>';      
      if ($comment['user_id']) {
    	  $output[]	= '<a href="'.$url.'" rel="nofollow">'.$username.'</a>';
      } else {
    	  $output[]	= $username;
      }
      $output[]		= '<small class="text-muted"><i class="fa fa-clock-o"></i> '.VDate::nice($comment['add_time']).'</small>';
      $output[]		= '</h6>';
      $output[]		= '</div>';
      $output[]		= '<div class="col col-md-4 d-flex justify-content-end">';
      
      if ($status == '0') {
    	  $output[]	= '<button class="comment-approve btn btn-sm" data-id="'.$comment_id.'" data-content-id="'.content_id.'" data-type="'.$type.'" data-toggle="tooltip" data-placement="top" title="'.__('approve-comment').'"><i class="fa fa-checked text-success"></i></button>';
      }
      
      if ($loggedin and (($comment['user_id'] == $user_id) or VAuth::group('Moderator', true))) {
    	  $output[]	= '<button class="comment-delete btn btn-sm" data-id="'.$comment_id.'" data-content-id="'.$content_id.'" data-type="'.$type.'" data-toggle="tooltip" data-placement="top" title="'.__('delete-comment').'"><i class="fa fa-trash text-danger"></i></button>';
      }
      
      $output[]		= '<span id="comment-spam-'.$comment_id.'" class="comment-spam-response">';
      $output[]		= '<button id="comment-spam-button-'.$comment_id.'" class="comment-spam btn btn-sm" data-id="'.$comment_id.'" data-content-id="'.$content_id.'" data-type="'.$type.'" data-toggle="tooltip" data-placement="top" title="'.__('report-spam').'"><i class="fa fa-flag text-warning"></i></button>';
      $output[]		= '</span>';      
	  $output[]		= '</div>';	  
	  $output[]		= '</div>';
	  $output[]		= '<p class="comment-text">'.nl2br(e($comment['comment'])).'</p>';
      $output[]		= '<div class="border-top">';
      
      if ($vote) {
    	  $output[]	= '<small class="text-success">'.$comment['likes'].'</small>';
      	  $output[]	= '<div class="btn-group btn-group-xs" role="group">';
          $output[]	= '<button class="'.$login.'comment-rate comment-rate-up btn btn-xs btn-light btn-rate" data-vote="up" data-type="'.$type.'" data-id="'.$comment_id.'" data-toggle="tooltip" data-placement="top" title="'.__('vote-up').'"><i class="fa fa-thumbs-up"></i></button>';
          $output[]	= '<button class="'.$login.'comment-rate comment-rate-down btn btn-xs btn-light btn-rate" data-vote="down" data-type="'.$type.'" data-id="'.$comment_id.'" data-toggle="tooltip" data-placement="top" title="'.__('vote-down').'"><i class="fa fa-thumbs-down"></i></button>';
      	  $output[]	= '</div>';
      }
      
      if ($reply and $allow_comment and !$parent_id) {
    	  $output[]	= '<button class="comment-reply btn btn-xs btn-light btn-reply" data-id="'.$comment_id.'" data-type="'.$type.'" data-content-id="'.$content_id.'"><i class="fa fa-reply"></i> '.__('reply').'</button>';
      }
      
      if ($vote) {
    	  $output[]	= '<small class="comment-vote-response"></small>';
      }
      
      if (!$parent_id and isset($comment['replies'])) {
    	  $class	= ($comment['replies'] == '0') ? 'd-none' : '';
  		  $output[]	= '<div id="comment-replies-container-'.$comment_id.'" class="mt-3 comment-replies-container'.$class.'">';
  		  
  		  if ($comment['replies'] > 0) {
  			  $output[] = p('comment_replies', $comment_id, $content_id, $type, $allow_comment, $submenu);
  		  }

    	  $output[]	= '</div>';
      }
      
      $output[]	= '</div>';
      
      if ($submenu == 'user-comments') {
    	  $output[]	= '<div class="btn-group btn-group-sm" role="group">';
      	  $output[]	= '<button class="btn btn-sm btn-success btn-action" data-id="'.$comment_id.'" data-action="approve">'.__('approve').'</button>';
      	  $output[]	= '<button class="btn btn-sm btn-danger btn-action" data-id="'.$comment_id.'" data-action="delete">'.__('delete').'</button>';
    	  $output[]	= '</div>';
      }
      
	  $output[]		= '</div>';
	  
	  $output[]		= '</div>';
	}
	
	if ($parent_id) {
		if ($comments_total > $start) {
			$output[]	= '<div class="w-100 pt-1 text-center text-muted"><button data-id="'.$parent_id.'" class="btn btn-link btn-sm comment-replies-load">'.__('view-all-replies').' ('.$comments_total.')</button></div>';
		}
	} else {
		if ($comments_total > VCfg::get($module.'.comments_per_page')) {
			$output[]	= '<div class="w-100 pt-3 text-center"><button id="more-comments-'.$content_id.'" class="btn btn-primary" data-id="'.$content_id.'" data-page="2" data-type="'.$type.'">'.__('load-more').'</button></div>';
		}
		
		$output[]	= '</div>';
	}
	
	return implode("\n", $output);
}
