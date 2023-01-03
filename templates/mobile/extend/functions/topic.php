<?php
function display_topics($topics, $id = null, $class = null)
{
    $id         = ($id) ? '-'.$id : '';
    $output		= array();
    $loggedin	= VAuth::loggedin();
    foreach ($topics as $topic) {
  		$icon		= ($loggedin and $topic['last_post_id'] > $topic['r_post_id']) ? 'fa-comments' : 'fa-comments-o';
  		$replies	= ($topic['total_replies'] == '1') ? __('reply') : __('replies');
  		$views		= ($topic['total_views'] == '1') ? __('view') : __('views');
    
  		$output[]	= '<div id="topic-'.$topic['topic_id'].$id.'" class="topic">';
  		$output[]	= '<div class="topic-info">';
  		$output[]	= '<div class="topic-read"><i class="fa '.$icon.' fa-2x"></i></div>';
  		$output[]	= '<div class="topic-title">';
  		
  		if ($topic['sticky']) {
  			$output[]	= '<span class="label label-warning">'.__('sticky').'</span> ';
  		}
  		
  		$output[]	= '<a href="'.REL_URL.LANG.'/forum/topic/'.$topic['topic_id'].'/'.$topic['slug'].'/">'.e($topic['title']).'</a>';
  		$output[]	= '<span class="topic-posted">'.__('started-by').' <span class="username">'.e($topic['username']).'</span> '.__('on').' '.VDate::format($topic['add_time'], 'd M Y').'</span>';
  		$output[]	= '</div>';
  		$output[]	= '<div class="clearfix"></div>';
  		$output[]	= '</div>';
  		$output[]	= '<div class="topic-stats">';
  		$output[]	= '<span class="topic-count">'.$topic['total_replies'].'</span> '.$replies.'<br>';
  		$output[]	= '<span class="topic-count">'.$topic['total_views'].'</span> '.$views;
  		$output[]	= '</div>';
  		$output[]	= '<div class="topic-last">';
  		$output[]	= __('by').' <a href="'.REL_URL.LANG.'/users/'.e($topic['post_username']).'/" rel="nofollow"><span class="username">'.e($topic['post_username']).'</span></a><br>';
  		$output[]	= '<span class="content-info">'.VDate::format($topic['last_post_time'], 'd M Y - h:i A').'</span>';
  		$output[]	= '</div>';
  		$output[]	= '<div class="clearfix"></div>';
  		$output[]	= '</div>';
	}
	
	return implode('', $output);
}
