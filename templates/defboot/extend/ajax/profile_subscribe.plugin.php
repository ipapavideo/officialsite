<?php
function ajax_plugin_profile_subscribe()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger', 'subscribers' => 0);
	
    VLanguage::load('frontend.profile');
    
//    if (VCfg::get('profile.subscribe') != '1') {
//        $data['msg'] = __('subscribe-disabled');
//        return json_encode($data);
//    }
    
    if (!isset($_POST['user_id']) or !isset($_POST['action'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $subscriber_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$subscriber_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('subscribe-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $user_id	= $filter->get('user_id', 'INT');
    $action		= $filter->get('action');

    $smodel		= VModel::load('subscribe', 'profile');    
    if (!$user = $smodel->content($user_id)) {
  		$data['msg']	= 'Invalid request (profile)!';
  		return json_encode($data);
    }
    
    $subscribers	= $user['subscribers'];
    
    if ($action == 'add') {
		if ($smodel->exists($user_id, $subscriber_id)) {
  			$data['msg']	= __('subscribe-already');
  			return json_encode($data);
  		}
    
  		$smodel->add($user_id, $subscriber_id);
  		
  		if (VCfg::get('user.points')) {
  			$pmodel	= VModel::load('points', 'user');
  			$pmodel->add($user_id, 'subscribe-add');
  		}
  		
        if (VCfg::get('user.activity')) {
            $amodel = VModel::load('activity', 'core');
            $amodel->add($subscriber_id, 'profile-subscribe', array('id' => $user_id, 'data' => $user), 1);
        }  		
  		
  		$data['code']			= '<button id="subscribe-del" class="btn btn-ns btn-submit btn-subscribe" data-action="del" data-toggle="tooltip" data-placement="top" title="'.__('model-unsubscribe-help').'"><i class="fa fa-rss"></i> '.__('unsubscribe').'</button>';
  		$data['subscribers']    = $subscribers+1;
  		$data['status']			= 1;
    } elseif ($action == 'del') {
  		if (!$smodel->exists($user_id, $subscriber_id)) {
      		$data['msg']    = __('subscribe-not');
      		return json_encode($data);
  		}

  		$smodel->del($user_id, $subscriber_id);

  		if (VCfg::get('user.points')) {
  			$pmodel	= VModel::load('points', 'user');
  			$pmodel->add($user_id, 'subscribe-del');
  		}

        if (VCfg::get('user.activity')) {
            $amodel = VModel::load('activity', 'core');
            $amodel->del($user_id, 'profile-subscribe', $subscriber_id);
        }  		
        
  		$data['code']   		= '<button id="subscribe-add" class="<?php echo $login; ?>btn btn-ns btn-submit btn-subscribe" data-action="add" data-toggle="tooltip" data-placement="top" title="'.__('model-subscribe-help').'"><i class="fa fa-rss"></i> '.__('subscribe').'</button>';
  		$data['subscribers']    = ($subscribers >= 1) ? $subscribers-1 : 0;
  		$data['status'] 		= 1;    
    } else {
  		$data['msg']	= 'Invalid request (action)!';
    }
    
    
	return json_encode($data);
}
