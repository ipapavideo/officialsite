<?php
function ajax_plugin_user_photo_favorite_delete()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.user');
    
    if (!isset($_POST['photo_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('video-favorite-delete-login');
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $photo_id	= $filter->get('photo_id', 'INT');
    
    $fmodel	= VModel::load('favorite', 'photo');
    $fmodel->del($photo_id, $user_id);
    
    $umodel	= VModel::load('user', 'user');
    $umodel->update($user_id, array('favorite_photos' => 'favorite_photos-1'), 'user_stats');

    if (VCfg::get('user.activity')) {
  		$acmodel = VModel::load('activity', 'core');
        $acmodel->del($user_id, 'photo-favorite', $photo_id);
    }
    
    if (VCfg::get('user.points')) {
        VModel::load('points', 'user')->add($user_id, 'photo-favorite-del');
    }    

	$data['msg']	= __('photo-favorite-deleted');
	$data['status']	= 1;
	
	return json_encode($data);	
}
