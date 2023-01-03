<?php
function ajax_plugin_profile_post_rate()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
	
    VLanguage::load('frontend.profile');
    
    if (VCfg::get('profile.allow_rating') != '1') {
        $data['msg'] = __('rating-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['rating']) or !isset($_POST['wall_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (VCfg::get('profile.rating_type') == 'user' && !$user_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('rating-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $wall_id	= $filter->get('wall_id', 'INT');
    $vote		= $filter->get('rating', 'INT');
    $ip			= VServer::ipv();

	$rmodel		= VModel::load('rate', 'profile');
	if (!$wall = $rmodel->content($wall_id)) {
        $data['msg'] = __('invalid-wall-post');
        return json_encode($data);
	}
	
    if (!upref($wall['wall_rating'], $wall['user_id'], $user_id)) {
        $data['msg'] = 'Invalid request (perm)!';
        return json_encode($data);
    }		

	if (VCfg::get('profile.rating_count')) {
		if (VCfg::get('profile.rating_type') == 'user') {
            $ret = $rmodel->getRatingById($wall_id, $user_id);
        } else {
            $ret = $rmodel->getRatingByIP($wall_id, $ip);
        }

        if ($ret) {
            $data['msg'] = __('rating-already');
            return json_encode($data);
        }
	}
		
	$likes		= ($vote === 1) ? $wall['likes']+1 : $wall['likes'];
	$rated_by	= $wall['rated_by']+1;
	$rating		= ($vote === 1) ? $wall['rating']+5 : $wall['rating']+1;
	$rating		= round($rating/2, 2);

	$rmodel->addRating($wall_id, $user_id, $ip, $vote);

	$percent	= $likes*100/$rated_by;
	
	$wmodel		= VModel::load('wall', 'profile');
	$wmodel->update($wall_id, array(		
		'likes'		=> $likes,
		'rating'	=> $rating,
		'rated_by'	=> $rated_by,
		'percent'	=> $percent
	));
	
	if (VCfg::get('cache')) {
		$cache	= VF::factory('cache');
		$cache->del('wall-rating-content-'.$wall_id);
	}
	
    if (VCfg::get('user.points')) {
        VModel::load('points', 'user')->add($user_id, 'wall-rate');
    }	
	
	$percent	= round($percent);
	$code		= array();
	$class 		= ($percent >= 50 or $percent == '0') ? 'text-success' : 'text-danger';
	$code[]		= '<span class="wall-percent '.$class.'">'.$percent.'%</span> ';
    $code[]		= '<button class="btn btn-rating rate-wall" data-id="'.$wall_id.'" data-rating="1" data-toggle="tooltip" data-placement="top" title="'.__('i-like-this').'" disabled><i id="thumbs-up" class="fa fa-thumbs-up"></i></button> ';
    $code[]		= '<button class="btn btn-rating rate-wall" data-id="'.$wall_id.'" data-rating="0" data-toggle="tooltip" data-placement="top" title="'.__('i-dislike-this').'" disabled><i id="thumbs-down" class="fa fa-thumbs-down"></i></button>';
	
	$data['code']	= implode('', $code);
	$data['rating']	= $vote;
	$data['status']	= 1;
	
	return json_encode($data);	
}
