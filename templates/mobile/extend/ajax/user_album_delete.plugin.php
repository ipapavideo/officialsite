<?php
function ajax_plugin_user_album_delete()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.photo');
    
    if (VCfg::get('photo.allow_delete') != '1') {
        $data['msg'] = __('photo-del-disabled');
        return json_encode($data);
    }    
    
    if (!isset($_POST['album_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('photo-del-login');
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $album_id	= $filter->get('album_id', 'INT');
    
    $amodel		= VModel::load('album', 'photo', true);
	if (!$album = $amodel->get($album_id, array('pa.user_id', 'pa.type', 'pa.status'))) {
		$data['msg']	= 'Invalid request (album)';
		return json_encode($data);
	}
	
	if ($album['user_id'] != $user_id or $album['status'] !== 1) {
		$data['msg']	= 'Invalid request (perms)!';
		return json_encode($data);
	}
	
	$method	= VCfg::get('photo.delete_method');
	if ($method == 'delete' or $method == 'mark') {
		$mark	= ($method == 'mark') ? true : false;
		VHelper::load('photo.album');
		VHelper_photo_album::del($album_id, $mark);
	} elseif ($method == 'suspend') {
		$amodel->update($album_id, array('status' => 0));
	} elseif ($method == 'change') {
		$username	= VCfg::get('photo.delete_username');
		$umodel		= VModel::load('user', 'user');
		if ($user_id = $umodel->exists('username', $username)) {
			$column = ($album['type'] == '0') ? 'public' : 'private';
			$amodel->update($album_id, array('user_id' => $user_id));
			$umodel->update($user_id, array('has_albums' => 1));
			$umodel->update($user_id, array('albums' => 'albums+1', $column.'_albums' => $column.'_albums+1'));
			$umodel->update($p_user_id, array('albums' => 'albums-1', $column.'_albums' => $column.'_albums-1'));
			
			if ($photos = $amodel->photos($album_id)) {
				$pmodel	= VModel::load('photo', 'photo', true);
				foreach ($photos as $photo) {
					$column 	= ($photo['type'] == '0') ? 'public' : 'private';
					$p_user_id	= ($photo['user_id']) ? $photo['user_id'] : $album['user_id'];
					$pmodel->update($photo_id, array('user_id' => $user_id));
					$umodel->update($user_id, array('has_albums' => 1));
					$umodel->update($user_id, array('photos' => 'photos+1', $column.'_photos' => $column.'_photos+1'));
					$umodel->update($p_user_id, array('photos' => 'photos-1', $column.'_photos' => $column.'_photos-1'));					
				}
			}
		}
	}
	
	$data['msg']	= __('album-deleted');
	$data['status']	= 1;
	
	return json_encode($data);	
}
