<?php
function ajax_plugin_photo_rate()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
	
    VLanguage::load('frontend.photo');
    
    if (VCfg::get('photo.allow_rating') != '1') {
        $data['msg'] = __('rating-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['rating']) or !isset($_POST['photo_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (VCfg::get('photo.rating_type') == 'user' && !$user_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('rating-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $photo_id	= $filter->get('photo_id', 'INT');
    $vote		= $filter->get('rating', 'INT');
    $ip			= VServer::ipv();

	$rmodel		= VModel::load('rate', 'photo');

	if (VCfg::get('photo.rating_count')) {
		if (VCfg::get('photo.rating_type') == 'user') {
            $ret = $rmodel->getRatingById($photo_id, $user_id);
        } else {
            $ret = $rmodel->getRatingByIP($photo_id, $ip);
        }

        if ($ret) {
            $data['msg'] = __('rating-already');
            return json_encode($data);
        }
	}
        
	if (!$photo = $rmodel->content($photo_id)) {
        $data['msg'] = __('invalid-photo');
        return json_encode($data);
	}
	
	if (!$album = $rmodel->album($photo['album_id'])) {
        $data['msg'] = __('invalid-album');
        return json_encode($data);
	}
		
	$likes			= ($vote === 1) ? $photo['likes']+1 : $photo['likes'];
	$rated_by		= $photo['rated_by']+1;
	$rating			= ($vote === 1) ? $photo['rating']+5 : $photo['rating']+1;
	$rating			= round($rating/2, 2);

	$rmodel->addRating($photo_id, $user_id, $ip, $vote);

	$percent		= $likes*100/$rated_by;
	$percent_today	= $rmodel->percent($photo_id, 'today');
	$percent_week	= $rmodel->percent($photo_id, 'week');
	$percent_month	= $rmodel->percent($photo_id, 'month');
	$percent_year	= $rmodel->percent($photo_id, 'year');
	
	$pmodel	= VModel::load('photo', 'photo');
	$pmodel->update($photo_id, array(
		'likes' => $likes,
		'rated_by' => $rated_by,
		'rating' => $rating,
		'percent' => $percent,
		'percent_today' => $percent_today,
		'percent_week' => $percent_week,
		'percent_month' => $percent_month,
		'percent_year' => $percent_year
	));
	
	$a_likes			= ($vote === 1) ? $album['likes']+1 : $album['likes'];
	$a_rated_by			= $album['rated_by']+1;
	$a_rating			= ($vote === 1) ? $album['rating']+5 : $album['rating']+1;
	$a_rating			= round($a_rating/2, 2);
	$a_percent			= $a_likes*100/$a_rated_by;
	if ($album['percent_today'] > 0) {
		$a_percent_today	= ($vote === 1) ? ($album['percent_today']+100)/2 : $album['percent_today']/2;
	} else {
		$a_percent_today	= ($vote === 1) ? 100 : 0;
	}

	if ($album['percent_week'] > 0) {
		$a_percent_week		= ($vote === 1) ? ($album['percent_week']+100)/2 : $album['percent_week']/2;
	} else {
		$a_percent_week		= ($vote === 1) ? 100 : 0;
	}

	if ($album['percent_month'] > 0) {
		$a_percent_month	= ($vote === 1) ? ($album['percent_month']+100)/2 : $album['percent_month']/2;
	} else {
		$a_percent_month	= ($vote === 1) ? 100 : 0;
	}

	if ($album['percent_year'] > 0) {
		$a_percent_year		= ($vote === 1) ? ($album['percent_year']+100)/2 : $album['percent_year']/2;
	} else {
		$a_percent_year		= ($vote === 1) ? 100 : 0;
	}
	
	$amodel	= VModel::load('album', 'photo');
	$amodel->update($photo['album_id'], array(
		'likes'			=> $a_likes,
		'rated_by'		=> $a_rated_by,
		'rating'		=> $a_rating,
		'percent'		=> $a_percent,
		'percent_today'	=> $a_percent_today,
		'percent_week'	=> $a_percent_week,
		'percent_month'	=> $a_percent_month,
		'percent_year'	=> $a_percent_year
	));
	
    if (VCfg::get('user.points')) {
        VModel::load('points', 'user')->add($user_id, 'photo-rate');
    }	
	
	$cache		= VF::factory('cache');
	$cache->del('photo-rating-content-'.$photo_id);
	
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
