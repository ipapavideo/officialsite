<?php
function ajax_plugin_model_rate()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
	
    VLanguage::load('frontend.model');
    
    if (VCfg::get('model.allow_rating') != '1') {
        $data['msg'] = __('rating-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['rating']) or !isset($_POST['model_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (VCfg::get('model.rating_type') == 'user' && !$user_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('rating-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $model_id	= $filter->get('model_id', 'INT');
    $vote		= $filter->get('rating', 'INT');
    $ip			= VServer::ipv();
    $rmodel		= VModel::load('rate', 'model');

	$db = VF::factory('database');
	if (VCfg::get('model.rating_count')) {
		if (VCfg::get('model.rating_type') == 'user') {
			$ret = $rmodel->getRatingById($model_id, $user_id);
		} else {
			$ret = $rmodel->getRatingByIP($model_id, $ip);
		}
			
        if ($ret) {
            $data['msg'] = __('rating-already');
            return json_encode($data);
        }			
	}
        
    if (!$model = $rmodel->content($model_id)) {    
        $data['msg'] = 'Invalid model!';
        return json_encode($data);
	}
		
	$likes		= ($vote === 1) ? $model['likes']+1 : $model['likes'];
	$rated_by	= $model['rated_by']+1;
	$rating		= ($vote === 1) ? $model['rating']+5 : $model['rating']+1;
	$rating		= round($rating/2, 2);		
	
	$mmodel		= VModel::load('model', 'model');
	$rmodel->addRating($model_id, $user_id, $ip, $vote);

    $percent        = $likes*100/$rated_by;
    $percent_today  = $rmodel->percent($model_id, 'today');
    $percent_week   = $rmodel->percent($model_id, 'week');
    $percent_month  = $rmodel->percent($model_id, 'month');
    $percent_year   = $rmodel->percent($model_id, 'year');
    
    $mmodel->update($model_id, array(
        'likes' => $likes,
        'rated_by' => $rated_by,
        'rating' => $rating,
        'percent' => $percent,
        'percent_today' => $percent_today,
        'percent_week' => $percent_week,
        'percent_month' => $percent_month,
        'percent_year' => $percent_year
    ));
    
    if (VCfg::get('user.points')) {
  		VModel::load('points', 'user')->add($user_id, 'model-rate');
    }
    
    $cache			= VF::factory('cache');
    $cache->del('model-'.$model_id);
    $cache->del('model-rating-content-'.$model_id);

	$percent	= round(($likes*100)/$rated_by);
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
