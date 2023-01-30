<?php
function ajax_plugin_video_rate()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
	
    VLanguage::load('frontend.video');
    
    if (VCfg::get('video.allow_rating') != '1') {
        $data['msg'] = __('rating-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['rating']) or !isset($_POST['video_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (VCfg::get('video.rating_type') == 'user' && !$user_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('rating-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $video_id	= $filter->get('video_id', 'INT');
    $vote		= $filter->get('rating', 'INT');
    $ip			= VServer::ipv(true);

	$rmodel		= VModel::load('rate', 'video');

	if (VCfg::get('video.rating_count')) {
		if (VCfg::get('video.rating_type') == 'user') {
            $ret = $rmodel->getRatingById($video_id, $user_id);
        } else {
            $ret = $rmodel->getRatingByIP($video_id, $ip);
        }

        if ($ret) {
            $data['msg'] = __('rating-already');
            return json_encode($data);
        }
	}
        
	if (!$video = $rmodel->content($video_id)) {
        $data['msg'] = __('invalid-video');
        return json_encode($data);
	}
		
	$likes			= ($vote === 1) ? $video['likes']+1 : $video['likes'];
	$rated_by		= $video['rated_by']+1;
	$rating			= ($vote === 1) ? $video['rating']+5 : $video['rating']+1;
	$rating			= round($rating/2, 2);

	$rmodel->addRating($video_id, $user_id, $ip, $vote);

	$percent		= $likes*100/$rated_by;
	$percent_today	= $rmodel->percent($video_id, 'today');
	$percent_week	= $rmodel->percent($video_id, 'week');
	$percent_month	= $rmodel->percent($video_id, 'month');
	$percent_year	= $rmodel->percent($video_id, 'year');
	
	$vmodel	= VModel::load('video', 'video');
	$vmodel->update($video_id, array(
		'likes' => $likes,
		'rated_by' => $rated_by,
		'rating' => $rating,
		'percent' => $percent,
		'percent_today' => $percent_today,
		'percent_week' => $percent_week,
		'percent_month' => $percent_month,
		'percent_year' => $percent_year
	));
	
	VF::factory('cache')->del('video-'.$video_id);
	
    if (VCfg::get('user.points')) {
        VModel::load('points', 'user')->add($user_id, 'video-rate');
    }
    
    if (VCfg::get('user.notify_rating')) {
  		if ($video['video_rating']) {
  			$search		= array('[USERNAME]', '[VIDEO_URL]', '[BASE_URL]', '[SITE_NAME]', '[NOTIFICATIONS_URL]');
  			$replace	= array($video['username'], video_view_url($video_id, $video['slug'], null, $video['premium'], true), BASE_URL, VCfg::get('site_name'), BASE_URL.'/user/login/?r=/user/notifications/');
  			VF::factory('email')->predefined('video-rating', $video['email'], $search, $replace, 'noreply');
  		}
    }	
	
	$percent	= round($percent);
	$code		= array();
	$code[]		= $percent.'% ('.$rated_by.' '.__('votes').')';
	$code[]		= '<div class="progress progress-danger">';
	$code[]		= '<div class="progress-bar bg-success" style="width: '.$percent.'%;"></div>';
	$code[]		= '<div class="progress-bar bg-danger" style="width: '.(100-$percent).'%"></div>';
	$code[]		= '</div>';
	
	$data['code']	= implode('', $code);
	$data['rating']	= $vote;
	$data['status']	= 1;
	
	return json_encode($data);	
}
