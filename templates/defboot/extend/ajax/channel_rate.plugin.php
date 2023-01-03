<?php
function ajax_plugin_channel_rate()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
	
    VLanguage::load('frontend.channel');
    
    if (VCfg::get('channel.allow_rating') != '1') {
        $data['msg'] = __('rating-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['rating']) or !isset($_POST['channel_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (VCfg::get('channel.rating_type') == 'user' && !$user_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('rating-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $channel_id	= $filter->get('channel_id', 'INT');
    $vote		= $filter->get('rating', 'INT');
    $ip			= VServer::ipv();
    $rmodel		= VModel::load('rate', 'channel');

	$db = VF::factory('database');
	if (VCfg::get('channel.rating_count')) {
		if (VCfg::get('channel.rating_type') == 'user') {
			$ret = $rmodel->getRatingById($channel_id, $user_id);
		} else {
			$ret = $rmodel->getRatingByIP($channel_id, $ip);
		}
			
        if ($ret) {
            $data['msg'] = __('rating-already');
            return json_encode($data);
        }			
	}
        
    if (!$channel = $rmodel->content($channel_id)) {    
        $data['msg'] = 'Invalid model!';
        return json_encode($data);
	}
		
	$likes		= ($vote === 1) ? $channel['likes']+1 : $channel['likes'];
	$rated_by	= $channel['rated_by']+1;
	$rating		= ($vote === 1) ? $channel['rating']+5 : $channel['rating']+1;
	$rating		= round($rating/2, 2);
	$percent	= $likes*100/$rated_by;
	
	$cmodel		= VModel::load('channel', 'channel');
	$cmodel->update($channel_id, array('likes' => $likes, 'rated_by' => $rated_by, 'rating' => $rating, 'percent' => $percent));
	$rmodel->addRating($channel_id, $user_id, $ip, $vote);
	
	VF::factory('cache')->del('channel-'.$channel_id);
	
	if (VCfg::get('user.points')) {
		VModel::load('points', 'user')->add($user_id, 'channel-rate');
	}
	
	$percent	= round($percent);
	$code		= array();
    $code[]		= $percent.'%';
    $code[]		= '<div class="progress">';
    $code[]		= '<div class="progress-bar" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%;">';
    $code[]		= '<span class="sr-only">'.$percent.'% Complete</span>';
    $code[]		= '</div></div>';
	
	$data['code']	= implode('', $code);
	$data['rating']	= $vote;
	$data['status']	= 1;
	
	return json_encode($data);	
}
