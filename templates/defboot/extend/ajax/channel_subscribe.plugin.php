<?php
function ajax_plugin_channel_subscribe()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger', 'subscribers' => 0);
	
    VLanguage::load('frontend.channel');
    
    if (VCfg::get('channel.subscribe') != '1') {
        $data['msg'] = __('subscribe-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['channel_id']) or !isset($_POST['action'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
  		$data['class']	= 'alert-warning';
        $data['msg']	= __('subscribe-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>'));
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $channel_id	= $filter->get('channel_id', 'INT');
    $action		= $filter->get('action');

    $smodel		= VModel::load('subscribe', 'channel');    
    if (!$channel = $smodel->content($channel_id)) {
  		$data['msg']	= 'Invalid request (channel)!';
  		return json_encode($data);
    }
    
    $subscribers = $channel['total_subscribers'];
        
    if ($action == 'add') {
		if ($smodel->exists($channel_id, $user_id)) {
  			$data['msg']	= __('subscribe-already');
  			return json_encode($data);
  		}
    
  		$smodel->add($channel_id, $user_id);    
  		
  		if (VCfg::get('user.activity')) {
  			$amodel	= VModel::load('activity', 'core');
  			$amodel->add($user_id, 'channel-subscribe', array('id' => $channel_id, 'data' => $channel));
  		}
  		
  		if (VCfg::get('user.points')) {
  			VModel::load('points', 'user')->add($user_id, 'channel-subscribe-add');
  		}

  		if (VCfg::get('user.notify_subscribe') and $channel['channel_subscribe']) {
  			$search		= array('[CHANNEL_NAME]', '[USERNAME]', '[SUBSCRIBER]', '[BASE_URL]', '[SITE_NAME]', '[NOTIFICATIONS_URL]');
  			$replace	= array($channel['name'], $channel['username'], VSession::get('username'), BASE_URL, VCfg::get('site_name'), BASE_URL.'/user/login/?r=/user/notifications/');
  			VF::factory('email')->predefined('channel-subscribe', $channel['email'], $search, $replace, 'noreply');
  		}
  		
  		$data['code']			= '<button id="subscribe-del" class="btn btn-ns btn-submit btn-subscribe" data-action="del" data-toggle="tooltip" data-placement="top" title="'.__('channel-unsubscribe-help').'"><i class="fa fa-rss"></i> '.__('unsubscribe').'</button>';
  		$data['subscribers']	= $subscribers+1;
  		$data['status']			= 1;
    } elseif ($action == 'del') {
  		if (!$smodel->exists($channel_id, $user_id)) {
      		$data['msg']    = __('subscribe-not');
      		return json_encode($data);
  		}

  		if (VCfg::get('user.activity')) {
  			$amodel	= VModel::load('activity', 'core');
  			$amodel->del($user_id, 'channel-subscribe', $channel_id);
  		}

  		if (VCfg::get('user.points')) {
  			VModel::load('points', 'user')->add($user_id, 'channel-subscribe-del');
  		}
  		
  		$smodel->del($channel_id, $user_id);
  		$data['code']   		= '<button id="subscribe-add" class="<?php echo $login; ?>btn btn-ns btn-submit btn-subscribe" data-action="add" data-toggle="tooltip" data-placement="top" title="'.__('channel-subscribe-help').'"><i class="fa fa-rss"></i> '.__('subscribe').'</button>';
  		$data['subscribers']	= ($subscribers >= 1) ? $subscribers-1 : 0;
  		$data['status'] 		= 1;    
    } else {
  		$data['msg']	= 'Invalid request (action)!';
    }
    
    VF::factory('cache')->del('channel-'.$channel_id);
    
	return json_encode($data);
}
