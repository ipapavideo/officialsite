<?php
function ajax_plugin_user_video_favorite_delete()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.user');
    
    if (!isset($_POST['video_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('video-favorite-delete-login');
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $video_id	= $filter->get('video_id', 'INT');
    
    $fmodel	= VModel::load('favorite', 'video');
    $fmodel->del($video_id, $user_id);
    
    $umodel	= VModel::load('stats', 'user');
    $umodel->update($user_id, array('favorite_videos' => 'favorite_videos-1'));

    if (VCfg::get('user.activity')) {
  		$amodel = VModel::load('activity', 'core');
        $amodel->del($user_id, 'video-favorite', $video_id);
    }
    
    if (VCfg::get('user.points')) {
        VModel::load('points', 'user')->add($user_id, 'video-favorite-del');
    }    

	$data['msg']	= __('video-favorite-deleted');
	$data['status']	= 1;
	
	return json_encode($data);	
}
