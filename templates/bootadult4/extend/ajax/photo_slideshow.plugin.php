<?php
function ajax_plugin_photo_slideshow()
{
	$data 		= array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	if (!isset($_POST['album_id'])) {
		$data['msg']	= 'Invalid request!';
		return json_encode($data);
	}
	
	$filter		= VF::factory('filter');
	$album_id	= $filter->get('album_id', 'INT');
	$amodel		= VModel::load('album', 'photo');
	
	VLanguage::load('frontend.photo');
	
	if (!$album = $amodel->get($album_id, array('pa.user_id', 'pa.type', 'pa.status', 'u.username'))) {
		$data['msg']	= __('invalid-album');
		return json_encode($data);		
	}
	
	if ($album['status'] != '1') {
		$data['msg']	= __('invalid-album');
		return json_encode($data);		
	}
	
	if ($album['type'] == '1') {
		if (!VAuth::loggedin()) {
			$data['msg']	= __('slideshow-login');
			return json_encode($data);
		}
	
		$user_id	= (int) VSession::get('user_id');
		$fmodel		= VModel::load('friend', 'profile');
		if ($fmodel->exists($owner_id, $user_id) != '1') {
			$data['msg']	= __('slideshow-friends', '<a href="'.REL_URL.LANG.'/users/'.$album['username'].'">'.$album['username'].'</a>');
			return json_encode($data);
		}
	}
	
	$pmodel	= VModel::load('photo', 'photo');
	if (!$photos = $pmodel->photos($album_id, 1000)) {
		$data['msg']	= __('invalid-album');
		return json_encode($data);		
	}
	
	$code	= array();
	foreach ($photos as $photo) {
		$photo_id	= (int) $photo['photo_id'];
		$url		= ($photo['photo_url']) ? $photo['photo_url'] : BASE_URL.'/media/photos';	
		$caption	= e($photo['caption']);
		$code[]		= array(
			'src'		=> $url.'/'.$photo_id.'.'.$photo['ext'],
			'thumb'		=> PHOTO_THUMB_URL.'/'.$photo_id.'.jpg',
			'subHtml'	=> '<div class="text-center">'.$caption.'</div>'
		);
	}
	
	$data['code']	= json_encode($code);
	$data['status']	= 1;
	
	return json_encode($data);
}
