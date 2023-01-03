<?php
function ajax_plugin_profile_posts()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'page' => 3, 'end' => 0);
	
	if (!isset($_POST['user_id']) or !isset($_POST['page'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
	}
	
    VLanguage::load('frontend.profile');
    
    $filter		= VF::factory('filter');
    $user_id	= $filter->get('user_id', 'INT');
    $poster_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    $page		= $filter->get('page', 'INT');    
    
    $wmodel		= VModel::load('wall', 'profile');
    $per_page	= VCfg::get('profile.walls_per_page');
    $start		= ($page*$per_page)-$per_page;
    $posts		= $wmodel->walls($user_id, $start.', '.$per_page);
    if (!$posts) {
  		return json_encode($data);
    }
    
    $enabled		= VCfg::get('profile.comments');
    if ($enabled) {
  		$cmodel		= VModel::load('comment', 'profile');
    }
    
    $allow_comment	= VCfg::get('profile.allow_comment');
    $reply			= VCfg::get('profile.comment_replies');
    $vote			= VCfg::get('profile.comment_vote');
    $start			= VCfg::get('profile.replies_start');
    $login			= ($vote and !$poster_id) ? 'login ' : '';
    
    $code			= array();
    foreach ($posts as $index => $wall) {
  		if ($index >= $per_page) {
  			break;
  		}
  		
  		$content_id	= $wall['wall_id'];
  		$username 	= e($wall['username']);
  		$link 		= REL_URL.LANG.'/users/'.$username.'/';
  		$avatar 	= USER_URL.'/'.avatar(false, $wall['poster_id'], $wall['avatar'], $wall['gender'], true);
  		$alt		= __('username-avatar', $username);
  		
  		$code[]	= '<div class="stream">';
        $code[]	= '<div class="stream-header">';
        $code[]	= '<div class="stream-avatar">';
        $code[]	= '<a href="'.$link.'" rel="nofollow">';
        $code[]	= '<img src="'.$avatar.'" alt="'.$alt.'" width="50" class="img-rounded">';
        $code[]	= '</a>';
        $code[]	= '</div>';
        $code[]	= '<div class="stream-info">';
        $code[]	= '<a href="'.$link.'" rel="nofollow">'.$username.'</a>';
        
        if ($wall['user_id'] == $wall['poster_id']) {
      		$code[] = __('activity-profile-post-self'); 
      	} else {
      		$code[]	= __('activity-profile-post', '<a href="'.$link.'" rel="nofollow"><strong>'.$username.'</strong></a>');
      	}
        
        $code[]	= '<span class="stream-time"><i class="fa fa-clock-o"></i> '.VDate::nice($wall['add_time']).'</span>';
        $code[]	= '</div>';
        $code[]	= '<div class="clearfix"></div>';
        $code[]	= '</div>';
        $code[]	= '<div class="stream-content stream-content-post">';
        $code[]	= '<div id="wall-'.$content_id.'">';
        $code[]	= '<div class="wall-content">'.$wall['content'].'</div>';
        $code[]	= '<div class="wall-footer">';
        
        if ($wall['wall_rating']) {
      		$class 		= ($wall['percent'] >= 50 or $wall['percent'] == '0') ? 'text-success' : 'text-danger';
      		$disabled 	= (!upref($wall['wall_rating'], $wall['user_id'], $wall['poster_id'])) ? ' disabled="disabled"' : '';
        
      		$code[]	= '<div id="wall-rating-'.$content_id.'" class="wall-rating pull-left">';
      		$code[]	= '<span class="wall-percent '.$class.'">'.round($wall['percent']).'%</span>';
      		$code[]	= '<button class="btn btn-rating rate-wall" data-id="'.$content_id.'" data-rating="1" data-toggle="tooltip" data-placement="top" title="'.__('i-like-this').'"'.$disabled.'><i class="fa fa-thumbs-up"></i></button>';
    		$code[]	= '<button class="btn btn-rating rate-wall" data-id="'.$content_id.'" data-rating="0" data-toggle="tooltip" data-placement="top" title="'.__('i-dislike-this').'"'.$disabled.'><i class="fa fa-thumbs-down"></i></button>';
			$code[]	= '</div>';						
        }
        
        if ($enabled and $comment = upref($wall['wall_comments'], $wall['user_id'], $wall['poster_id'])) {
      		$code[]	= '<div class="wall-comment pull-left"><button class="btn btn-xs btn-link btn-post comment-wall" data-id="'.$content_id.'"><i class="fa fa-comment"></i> '.__('comment').'</button></div>';
        }
        
  		$code[]	= '<div class="wall-report pull-right"><button class="btn btn-xs btn-link btn-post report-wall" data-id="'.$content_id.'"><i class="fa fa-flag"></i></button></div>';
  		$code[]	= '<div class="clearfix"></div>';
        $code[]	= '</div>';
        
        if ($enabled) {
      		$code[]	= '<div id="wall-comments-'.$content_id.'" class="wall-comments">';
      		
      		if ($comment) {
      			if (($allow_comment and $poster_id) or $allow_comment == '2') {
      				$code[]	= '<div id="post-comment-'.$content_id.'" style="display:none;"><div class="comment-post-container"></div></div>';
      			}
      		}
      		
      		if ($wall['total_comments'] > 0) {
      			$comments	= $cmodel->comments('c.wall_id = ? AND c.parent_id = 0 AND c.status = 1', 'i', $content_id, 10);
      			if ($comments) {
      				$code[]	= '<div id="comments-container-'.$content_id.'" class="comments-container"><ul class="media-list">';
      				
      				foreach ($comments as $comment) {
    					$cusername 	= ($comment['user_id']) ? e($comment['username']) : e($comment['nickname']);
    					$status 	= (isset($comment['status'])) ? $comment['status'] : null;
    					$display	= (!isset($status)) ? ' style="display: none;"' : '';
    					$curl 		= REL_URL.LANG.'/users/'.$cusername.'/';
    					
      					
  						$code[]	= '<li id="comment-'.$comment['comment_id'].'" data-id="'.$comment['comment_id'].'" class="media">';
    					$code[]	= '<div class="media-left">';    					
      					$code[]	= '<a href="'.$curl.'" rel="nofollow">';
      					$code[]	= '<img src="'.USER_URL.'/'.avatar(false, $comment['user_id'], $comment['avatar'], $comment['gender']).'" alt="'.__('username-avatar', array($cusername)).'" width="64" class="media-object">';
      					$code[] = '</a>';
      					$code[]	= '</div>';
      					
      					$code[]	= '<div class="media-body">';
      					$code[]	= '<div class="media-heading">';
      					
      					if ($comment['user_id']) {
      						$code[]	= '<h4 class="pull-left"><a href="'.$curl.'" rel="nofollow">'.$cusername.'</a></h4>';
      					} else {
      						$code[]	= '<h4 class="pull-left">'.$cusername.'</h4>';
						}
						
						$code[]	= '<small><i class="fa fa-clock-o"></i> '.VDate::nice($comment['add_time']).'</small>';
						$code[]	= '<div class="media-buttons pull-right"'.$display.'>';
						
						if ($status == '0') {						
							$code[]	= '<button class="comment-approve btn btn-ns btn-success" data-id="'.$comment['comment_id'].'" data-content-id="'.$content_id.'" data-type="wall" data-toggle="tooltip" data-placement="top" title="'.__('approve-comment').'">'.__('approve').'</button>';
						}
						
						if (($comment['user_id'] == $poster_id) or VAuth::group('Moderator', true)) {
          					$code[]	= '<button class="comment-delete btn btn-ns btn-danger" data-id="'.$comment['comment_id'].'" data-content-id="'.$content_id.'" data-type="wall" data-toggle="tooltip" data-placement="top" title="'.__('delete-comment').'">'.__('delete').'</button>';
          				}

          				$code[]	= '<span id="comment-spam-'.$comment['comment_id'].'" class="comment-spam-response">';
            			$code[]	= '<button id="comment-spam-button-'.$comment['comment_id'].'" class="comment-spam btn btn-ns btn-warning" data-id="'.$comment['comment_id'].'" data-content-id="'.$content_id.'" data-type="wall" data-toggle="tooltip" data-placement="top" title="'.__('report-spam').'">'.__('spam').'</button>';
          				$code[]	= '</span>';
        				$code[]	= '</div>';
        				$code[]	= '<div class="clearfix"></div>';
        				$code[]	= '</div>';
        				$code[]	= '<p>'.nl2br(e($comment['comment'])).'</p>';
						$code[]	= '<div id="comment-footer-'.$comment['comment_id'].'" class="media-footer">';
						
						if ($vote) {
							$code[]	= '<span class="text-success">'.$comment['likes'].'</span>&nbsp;';
        					$code[]	= '<button class="'.$login.'comment-rate comment-rate-up btn btn-rate" data-vote="up" data-type="wall" data-id="'.$comment['comment_id'].'" data-toggle="tooltip" data-placement="top" title="'.__('vote-up').'"><i class="fa fa-thumbs-up"></i></button>&nbsp;';
        					$code[]	= '<button class="'.$login.'comment-rate comment-rate-down btn btn-rate" data-vote="down" data-type="wall" data-id="'.$comment['comment_id'].'" data-toggle="tooltip" data-placement="top" title="'.__('vote-down').'"><i class="fa fa-thumbs-down"></i></button>';
						}
						
						if ($reply and $allow_comment) {
							$code[]	= '<button class="comment-reply btn btn-xs btn-reply" data-id="'.$comment['comment_id'].'" data-type="wall" data-content-id="'.$content_id.'"><i class="fa fa-reply"></i> '.__('reply').'</button>';
						}
						
						$code[]	= '<small class="comment-vote-response"></small>';						
						$code[]	= '</div>';
						
						if (isset($comment['replies'])) {
							$display	= ($comment['replies'] == '0') ? ' style="display: none;"' : '';
							
							$code[]	= '<div id="comment-replies-container-'.$comment['comment_id'].'" class="comment-replies-container media"'.$display.'>';
							
							if ($comment['replies'] > 0) {
								$code[] = ajax_plugin_comment_pagination_replies($comment['comment_id'], 'wall', $poster_id, $start, $vote, $login, $cmodel);
							}
							
      						$code[]	= '</div>';
						}
      				}
      				
      				$code[]	= '</ul></div>';
      			}
      		} else {
      			$code[]	= '<div id="comments-container-'.$content_id.'" class="comments-container" style="display: none;"><ul class="media-list"></ul></div>';
      		}
      		
      		$code[]	= '</div>';
        }
        
        $code[]	= '</div>';
        $code[]	= '</div>';
        $code[]	= '</div>';
    }
    
    file_put_contents(TMP_DIR.'/logs/zzz.txt', implode("\n", $code));
    
    $data['code']	= implode('', $code);
    $data['status']	= 1;
    $data['page']   = $page+1;
    
    if (count($posts) < $per_page) {
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

    $output     = array();
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
            $output[]   = '<button class="comment-approve btn btn-ns btn-success" data-id="'.$comment_id.'">'.__('approve').'</button>';
        }
        
        if (($comment['user_id'] == $user_id) or VAuth::group('Moderator', true)) {
            $output[]   = '<button class="comment-delete btn btn-ns btn-danger" data-id="'.$comment_id.'">'.__('delete').'</button>';
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
