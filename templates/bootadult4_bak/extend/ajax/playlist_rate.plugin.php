<?php
function ajax_plugin_playlist_rate()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
	
    VLanguage::load('frontend.video');
    
    if (VCfg::get('playlist.allow_rating') != '1') {
        $data['msg'] = __('rating-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['rating']) or !isset($_POST['playlist_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (VCfg::get('playlist.rating_type') == 'user' && !$user_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('rating-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter			= VF::factory('filter');
    $playlist_id	= $filter->get('playlist_id', 'INT');
    $vote			= $filter->get('rating', 'INT');
    $ip				= VServer::ipv(true);
	$rmodel			= VModel::load('rate', 'playlist');

	if (VCfg::get('playlist.rating_count')) {
		if (VCfg::get('playlist.rating_type') == 'user') {
            $ret = $rmodel->getRatingById($playlist_id, $user_id);
        } else {
            $ret = $rmodel->getRatingByIP($playlist_id, $ip);
        }

        if ($ret) {
            $data['msg'] = __('rating-already');
            return json_encode($data);
        }
	}
        
	if (!$playlist = $rmodel->content($playlist_id)) {
        $data['msg'] = __('playlist-invalid');
        return json_encode($data);
	}
		
	$likes		= ($vote === 1) ? $playlist['likes']+1 : $playlist['likes'];
	$rated_by	= $playlist['rated_by']+1;
	$rating		= ($vote === 1) ? $playlist['rating']+5 : $playlist['rating']+1;
	$rating		= round($rating/2, 2);
	$percent	= $likes*100/$rated_by;		
	
	$pmodel	= VModel::load('playlist', 'playlist');
	$pmodel->update($playlist_id, array('likes' => $likes, 'rated_by' => $rated_by, 'rating' => $rating, 'percent' => $percent));
	$rmodel->addRating($playlist_id, $user_id, $ip, $vote);
	
    if (VCfg::get('user.points')) {
        VModel::load('points', 'user')->add($user_id, 'playlist-rate');
    }	

    $percent    = round($percent);
    $code       = array();
    $code[]     = $percent.'% ('.$rated_by.' '.__('votes').')';
    $code[]     = '<div class="progress progress-danger">';
    $code[]     = '<div class="progress-bar bg-success" style="width: '.$percent.'%;"></div>';
    $code[]     = '<div class="progress-bar bg-danger" style="width: '.(100-$percent).'%"></div>';
    $code[]     = '</div>';
	
	$data['code']	= implode('', $code);
	$data['rating']	= $vote;
	$data['status']	= 1;
	
	return json_encode($data);	
}
