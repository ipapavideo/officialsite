<?php
function ajax_plugin_photo_favorite()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger');
	
    VLanguage::load('frontend.photo');
    
    if (VCfg::get('photo.allow_favorite') != '1') {
        $data['msg'] = __('favorite-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['photo_id'])) {
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
    $photo_id	= $filter->get('photo_id', 'INT');
    $fmodel		= VModel::load('favorite', 'photo');

	if ($fmodel->exists($photo_id, $user_id)) {
        $data['msg'] = __('favorite-already');
        return json_encode($data);
	}
	
	if (!$photo = $fmodel->content($photo_id)) {
        $data['msg'] = __('invalid-photo');
        return json_encode($data);
	}
	
	$owner_id	= $photo['user_id'];
	if ($owner_id == $user_id) {
        $data['msg'] = __('favorite-owner');
        return json_encode($data);
	}
	
	$fmodel->add($photo_id, $user_id);
	
	VModel::load('album', 'photo')->update($photo['album_id'], array('total_favorites' => 'total_favorites+1'));	
	
	$umodel	= VModel::load('user', 'user');
	$umodel->update($user_id, array('favorite_photos' => 'favorite_photos+1'), 'user_stats', false);
	
    if (VCfg::get('user.activity')) {
  		$acmodel = VModel::load('activity', 'core');
        $acmodel->add($user_id, 'photo-favorite', array('id' => $photo_id, 'data' => $photo));
    }	
    
    if (VCfg::get('user.points')) {
  		VModel::load('points', 'user')->add($user_id, 'photo-favorite-add');
    }

	$data['status']	= 1;
	
	return json_encode($data);	
}
