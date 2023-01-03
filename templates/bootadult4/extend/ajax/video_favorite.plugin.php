<?php
function ajax_plugin_video_favorite()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
	
    VLanguage::load('frontend.video');
    
    if (VCfg::get('video.allow_favorite') != '1') {
        $data['msg'] = __('favorite-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['video_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('favorite-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $video_id	= $filter->get('video_id', 'INT');
    $fmodel		= VModel::load('favorite', 'video');

	if ($fmodel->exists($video_id, $user_id)) {
        $data['msg'] = __('favorite-already');
        return json_encode($data);
	}
	
	if (!$video = $fmodel->content($video_id)) {
        $data['msg'] = __('invalid-video');
        return json_encode($data);
	}
	
	$owner_id	= $video['user_id'];
	if ($owner_id == $user_id) {
        $data['msg'] = __('favorite-owner');
        return json_encode($data);
	}
	
	$fmodel->add($video_id, $user_id);
	
	$cache	= VF::factory('cache');
	$cache->get('video-'.$video_id);
	$cache->del('video-favorite-exists-'.$video_id.'-'.$user_id);
	$cache->del('user-favorite-videos-total-'.$user_id);
	$cache->del('user-favorite-videos-'.$user_id.'-21');
	$cache->del('user-favorite-videos-'.$user_id.'-6');
	
	$umodel	= VModel::load('user', 'user');
	$umodel->update($user_id, array('favorite_videos' => 'favorite_videos+1'), 'user_stats', false);
	
    if (VCfg::get('user.activity')) {
  		$amodel = VModel::load('activity', 'core');
        $amodel->add($user_id, 'video-favorite', array('id' => $video_id, 'data' => $video));
    }	
    
    if (VCfg::get('user.points')) {
        VModel::load('points', 'user')->add($user_id, 'video-favorite-add');
    }    

	$data['msg']	= __('video-favorite-success');
	$data['status']	= 1;
	
	return json_encode($data);	
}
