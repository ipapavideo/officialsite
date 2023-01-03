<?php
function ajax_plugin_user_video_delete()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.user');
    
    if (VCfg::get('video.allow_delete') != '1') {
        $data['msg'] = __('video-delete-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['video_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('video-delete-login');
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $video_id	= $filter->get('video_id', 'INT');
    
    $vmodel		= VModel::load('video', 'video');
	if (!$video = $vmodel->get($video_id)) {
		$data['msg']	= 'Invalid request (video)';
		return json_encode($data);
	}
	
	if ($video['user_id'] != $user_id or $video['status'] !== 1) {
		$data['msg']	= 'Invalid request (perms)!';
		return json_encode($data);
	}
	
	$method	= VCfg::get('video.delete_method');
	if ($method == 'delete' or $method == 'mark') {
		$mark	= ($method == 'mark') ? true : false;
		VHelper::load('video.manage');
		VHelper_video_manage::del($video_id, $mark);
	} elseif ($method == 'suspend') {
		$vmodel->update($video_id, array('status' => 0));
	} elseif ($method == 'change') {
		$username	= VCfg::get('video.delete_username');
		$umodel		= VModel::load('user', 'user');
		if ($user_id = $umodel->exists('username', $username)) {
			$column = ($video['type'] == '0') ? 'public' : 'private';
			$vmodel->update($video_id, array('user_id' => $user_id));
			$umodel->update($user_id, array('has_videos' => 1));
			$umodel->update($user_id, array('videos' => 'videos+1', $column.'_videos' => $column.'_videos+1'));
			$umodel->update($video['user_id'], array('videos' => 'videos-1', $column.'_videos' => $column.'_videos-1'));
		}
	}
	
	$data['msg']	= __('video-deleted');
	$data['status']	= 1;
	
	return json_encode($data);	
}
