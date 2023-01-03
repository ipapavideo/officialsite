<?php
function ajax_plugin_user_friend()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger', 'friends' => 0);
	
	VLanguage::load('frontend.user');
    VLanguage::load('frontend.profile');
    
    if (!isset($_POST['friend_id']) or !isset($_POST['action'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
  		return;
    }
    
    $filter		= VF::factory('filter');
    $friend_id	= $filter->get('friend_id', 'INT');
    $action		= $filter->get('action');

    $fmodel		= VModel::load('friend', 'profile');
    if ($fmodel->exists($user_id, $friend_id, true) != '0') {
  		$data['msg']	= 'Invalid request (exists)!';
  		return;
    }
    
    if (!$user = $fmodel->content($friend_id)) {
  		$data['msg']	= 'Invalid request (friend)!';
  		return json_encode($data);
    }
    
    if ($action == 'approve') {
  		$fmodel->update($user_id, $friend_id, 1);
  		$fmodel->add($friend_id, $user_id, 1);
  		
        $smodel = VModel::load('subscribe', 'profile');
        $smodel->add($user_id, $friend_id);
        
        $umodel = VModel::load('user', 'user');
        $umodel->update($user_id, array('friends' => 'friends+1'), 'user_stats');
        $umodel->update($friend_id, array('friends' => 'friends+1'), 'user_stats');

        if (VCfg::get('user.points')) {
            $pmodel = VModel::load('points', 'user');
            $pmodel->add($friend_id, 'friend-add');
            $pmodel->add($friend_id, 'subscribe-add');
        }          		
  		
        if (VCfg::get('user.activity')) {
            $amodel = VModel::load('activity', 'core');
            $amodel->add($user_id, 'profile-friend', array(
          	  'id'		=> $friend_id,
          	  'data'	=> $user
            ), 1);
            
            $amodel->add($friend_id, 'profile-friend', array(
          		'id'	=> $user_id,
          		'data'	=> array(
          			'username' 	=> VSession::get('username'),
          			'avatar'	=> VSession::get('avatar'),
          			'gender'	=> VSession::get('gender'),
          			'online'	=> time()+VCfg::get('user.online_expire')
            )), 1);            
        }
  		
  		$data['msg']	= 'Approved!';
  		$data['status']	= 1;
    } elseif ($action == 'deny') {
  		$fmodel->del($user_id, $friend_id);
  		$fmodel->del($friend_id, $user_id);
  		
  		$data['msg']	= 'Denied!';
  		$data['status']	= 1;
    } else {
  		$data['msg']	= 'Invalid request (action)!';
    }
    
	return json_encode($data);
}
