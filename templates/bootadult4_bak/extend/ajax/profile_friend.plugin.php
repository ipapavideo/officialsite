<?php
function ajax_plugin_profile_friend()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger', 'friends' => 0);
	
    VLanguage::load('frontend.profile');
    
    if (!isset($_POST['user_id']) or !isset($_POST['action'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $friend_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$friend_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('friend-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $user_id	= $filter->get('user_id', 'INT');
    $action		= $filter->get('action');

    $fmodel		= VModel::load('friend', 'profile');
    if (!$user = $fmodel->content($user_id)) {
  		$data['msg']	= 'Invalid request (profile)!';
  		return json_encode($data);
    }
    
    if ($user['allow_friends'] == '0') {
  		$data['msg']	= 'Invalid request (disabled)!';
  		return json_encode($data);
    }
    
    $friends			= $user['friends'];
    $data['friends']	= $friends;
    
    if ($action == 'add') {
  		$status	= $fmodel->exists($user_id, $friend_id, true);
  		if (is_int($status)) {
  			if ($status == '0') {
  				$data['code']	= '<span class="text-warning">'.__('request-already-sent').'</span>';
  			} elseif ($status == '1') {
  				$data['code']	= '<span class="text-success">'.__('already-friends').'</span>';
  			} elseif ($status == '2') {
  				$data['code']	= '<span class="text-danger">'.__('friendship-denied').'</span>';
  			}
  		
  			$data['status'] = 1;
  			return json_encode($data);
  		}
  		
  		$status	= ($user['allow_friends'] == '2') ? 0 : 1;
  		$fmodel->add($user_id, $friend_id, $status);
  		
  		if ($status === 0) {
  			$data['status']	= 1;
  			$data['code'] 	= '<span class="text-success">'.__('request-sent').'</span>';
  			return json_encode($data);
  		}
  		
  		$fmodel->add($friend_id, $user_id, 1);
  		
  		$smodel	= VModel::load('subscribe', 'profile');
  		if (!$smodel->exists($friend_id, $user_id)) {
  			$smodel->add($friend_id, $user_id);
  		}
  		
  		$umodel	= VModel::load('user', 'user');
  		$umodel->update($user_id, array('friends' => 'friends+1'), 'user_stats');
  		$umodel->update($friend_id, array('friends' => 'friends+1'), 'user_stats');
  		
  		if (VCfg::get('user.points')) {
  			$pmodel	= VModel::load('points', 'user');
  			$pmodel->add($friend_id, 'friend-add');
  			$pmodel->add($user_id, 'friend-add');
  		}
  		
        if (VCfg::get('user.activity')) {
      		$status	= ($status === 1) ? 1 : 0;
            $amodel = VModel::load('activity', 'core');
            $amodel->add($user_id, 'profile-friend', array(
          		'id'	=> $friend_id,
          		'data'	=> array(
          			'username' 	=> VSession::get('username'),
          			'avatar'	=> VSession::get('avatar'),
          			'gender'	=> VSession::get('gender'),
          			'online'	=> time()+VCfg::get('user.online_expire')
            )), $status);
                        
            $amodel->add($friend_id, 'profile-friend', array(
          		'id'	=> $user_id,
          		'data'	=> $user
            ), $status);            
        }
  		
  		$data['code']		= '<button id="friend-del" class="btn btn-xs btn-primary rounded-pill btn-friend" data-action="del"><i class="fa fa-user-times"></i> '.__('unfriend').'</button>';
  		$data['friends']	= $friends+1;
  		$data['status']		= 1;
    } elseif ($action == 'del') {
  		if (!$fmodel->exists($user_id, $friend_id)) {
      		$data['msg']    = 'Invalid request (exists)!';
      		return json_encode($data);
  		}

  		$fmodel->del($user_id, $friend_id);
  		$fmodel->del($friend_id, $user_id);

  		$smodel	= VModel::load('subscribe', 'profile');
  		$smodel->del($friend_id, $user_id);

  		if (VCfg::get('user.points')) {
  			$pmodel	= VModel::load('points', 'user');
  			$pmodel->add($user_id, 'friend-del');
  			$pmodel->add($friend_id, 'friend-del');
  		}

        if (VCfg::get('user.activity')) {
            $amodel = VModel::load('activity', 'core');
            $amodel->del($user_id, 'profile-friend', $friend_id);
            $amodel->del($friend_id, 'profile-friend', $user_id);
        }  		
        
  		$data['code']   	= '<button id="friend-add" class="btn btn-xs btn-primary rounded-pill btn-friend" data-action="add"><i class="fa fa-user-plus"></i> '.__('add-friend').'</button>';
  		$data['friends']    = ($friends >= 1) ? $friends-1 : 0;
  		$data['status'] 	= 1;    
    } else {
  		$data['msg']	= 'Invalid request (action)!';
    }
    
    
	return json_encode($data);
}
