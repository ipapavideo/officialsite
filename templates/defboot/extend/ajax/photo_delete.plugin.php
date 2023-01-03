<?php
function ajax_plugin_photo_delete()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.photo');
    
    if (VCfg::get('photo.allow_delete') != '1') {
        $data['msg'] = __('photo-del-disabled');
        return json_encode($data);
    }    
    
    if (!isset($_POST['photo_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('photo-del-login');
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $photo_id	= $filter->get('photo_id', 'INT');
    
    $pmodel		= VModel::load('photo', 'photo', true);
	if (!$photo = $pmodel->get($photo_id, array('p.user_id', 'p.type', 'p.status', 'pa.user_id AS a_user_id'))) {
		$data['msg']	= 'Invalid request (photo)';
		return json_encode($data);
	}
	
	$p_user_id	= ($photo['user_id']) ? $photo['user_id'] : $photo['a_user_id'];
	
	if ($p_user_id != $user_id or $photo['status'] !== 1) {
		$data['msg']	= 'Invalid request (perms)!';
		return json_encode($data);
	}
	
	$method	= VCfg::get('photo.delete_method');
	if ($method == 'delete' or $method == 'mark') {
		$mark	= ($method == 'mark') ? true : false;
		VHelper::load('photo.photo');
		VHelper_photo_photo::del($photo_id, $mark);
	} elseif ($method == 'suspend') {
		$pmodel->update($photo_id, array('status' => 0));
	} elseif ($method == 'change') {
		$username	= VCfg::get('photo.delete_username');
		$umodel		= VModel::load('user', 'user');
		if ($user_id = $umodel->exists('username', $username)) {
			$column = ($photo['type'] == '0') ? 'public' : 'private';
			$pmodel->update($photo_id, array('user_id' => $user_id));
			$umodel->update($user_id, array('has_photos' => 1));
			$umodel->update($user_id, array('photos' => 'photos+1', $column.'_photos' => $column_photos.'+1'));
			$umodel->update($p_user_id, array('photos' => 'photos-1', $column.'_photos' => $column_photos.'-1'));
		}
	}
	
	$data['msg']	= __('photo-deleted');
	$data['status']	= 1;
	
	return json_encode($data);	
}
