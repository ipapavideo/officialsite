<?php
function template_plugin_topics($topics, $user_id)
{
	$output	= array();
	
	foreach ($topics as $index => $topic) {
		$border		= (isset($topics[$index+1])) ? ' border-bottom' : '';
		$icon		= ($user_id and $topic['last_post_id'] > $topic['r_post_id']) ? 'fa-comments' : 'fa-comments-o';
		$reply		= ($topic['total_replies'] == '1') ? __('reply') : __('replies');
		$view		= ($topic['total_views'] == '1') ? __('view') : __('views');
	
		$output[]	= '<div class="row no-gutters'.$border.'">';
		$output[]	= '<div class="col-12 col-sm-6 d-flex align-items-center">';
		$output[]	= '<div class="topic-read">';
		$output[]	= '<i class="fa '.$icon.' fa-2x"></i>';
		$output[]	= '</div>';
		$output[]	= '<div class="d-flex flex-column topic-title ml-1">';
		
		if ($topic['sticky']) {
			$output[]	= '<span class="label label-warning topic-sticky">'.__('sticky').'</span>';
		}
		
		$output[]	= '<a href="'.REL_URL.LANG.'/forum/topic/'.$topic['topic_id'].'/'.$topic['slug'].'/" class="h5 mb-0">'.e($topic['title']).'</a>';		
		$output[]	= '<small class="topic-posted text-muted">'.__('started-by').' <span class="username">'.e($topic['username']).'</span> '.__('on').' '.VDate::format($topic['add_time'], 'd M Y').'</small>';
		$output[]	= '</div></div>';
		$output[]	= '<div class="col-12 col-sm-6 d-flex align-items-center text-muted">';
		$output[]	= '<div class="flex-fill">';
		$output[]	= '<div class="d-flex flex-column">';
		$output[]	= '<div class="topic-info small"><span class="topic-count">'.$topic['total_replies'].'</span> '.$reply.'</div>';
		$output[]	= '<div class="topic-info small"><span class="topic-count">'.$topic['total_views'].'</span> '.$view.'</div>';
		$output[]	= '</div></div>';
		$output[]	= '<div class="flex-fill align-items-end">';
		$output[]	= ' <div class="d-flex flex-column align-items-end">';
		$output[]	= '<small class="font-weight-bold">'.__('by').' <a href="'.REL_URL.LANG.'/users/'.e($topic['post_username']).'"><span class="username">'.e($topic['post_username']).'</span></a></small>';
		$output[]	= '<small class="text-muted">'.VDate::format($topic['last_post_time'], 'd M Y - h:i A').'</small>';
		$output[]	= '</div></div></div></div>';	
	}
	
	return implode('', $output);
}
