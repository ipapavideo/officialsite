<?php
function ajax_plugin_model_subscribe()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger', 'subscribers' => 0);
	
    VLanguage::load('frontend.model');
    
    if (VCfg::get('model.subscribe') != '1') {
        $data['msg'] = __('subscribe-disabled');
        return json_encode($data);
    }
    
    if (!isset($_POST['model_id']) or !isset($_POST['action'])) {
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
    $model_id	= $filter->get('model_id', 'INT');
    $action		= $filter->get('action');

    $smodel		= VModel::load('subscribe', 'model');    
    if (!$model = $smodel->content($model_id)) {
  		$data['msg']	= 'Invalid request (model)!';
  		return json_encode($data);
    }
    
    $subscribers	= $model['total_subscribers'];
    
    if ($action == 'add') {
		if ($smodel->exists($model_id, $user_id)) {
  			$data['msg']	= __('model-subscribe-already');
  			return json_encode($data);
  		}
    
  		$smodel->add($model_id, $user_id);    
  		
        if (VCfg::get('user.activity')) {
            $amodel = VModel::load('activity', 'core');
            $amodel->add($user_id, 'model-subscribe', array('id' => $model_id, 'data' => $model));
        }  		
        
        if (VCfg::get('user.points')) {
      		VModel::load('points', 'user')->add($user_id, 'model-subscribe-add');
        }
        
        if (VCfg::get('cache')) {
      		$cache	= VF::factory('cache');
      		$cache->del('model-'.$model_id);
      		$cache->del('model-subscriber-exists-'.$model_id.'-'.$user_id);
      		$cache->del('model-subscribe-content-'.$model_id);
      	}
  		
  		$data['code']			= '<button id="subscribe-del" class="btn btn-ns btn-submit btn-subscribe" data-action="del" data-toggle="tooltip" data-placement="top" title="'.__('model-unsubscribe-help').'"><i class="fa fa-rss"></i> '.__('unsubscribe').'</button>';
  		$data['subscribers']    = $subscribers+1;
  		$data['status']			= 1;
    } elseif ($action == 'del') {
  		if (!$smodel->exists($model_id, $user_id)) {
      		$data['msg']    = __('subscribe-not');
      		return json_encode($data);
  		}

  		$smodel->del($model_id, $user_id);

        if (VCfg::get('user.activity')) {
            $amodel = VModel::load('activity', 'core');
            $amodel->del($user_id, 'model-subscribe', $model_id);
        }  		

        if (VCfg::get('user.points')) {
      		VModel::load('points', 'user')->add($user_id, 'model-subscribe-del');
        }

        if (VCfg::get('cache')) {
      		$cache	= VF::factory('cache');
      		$cache->del('model-'.$model_id);
      		$cache->del('model-subscriber-exists-'.$model_id.'-'.$user_id);
      		$cache->del('model-subscribe-content-'.$model_id);
      	}
        
  		$data['code']   		= '<button id="subscribe-add" class="<?php echo $login; ?>btn btn-ns btn-submit btn-subscribe" data-action="add" data-toggle="tooltip" data-placement="top" title="'.__('model-subscribe-help').'"><i class="fa fa-rss"></i> '.__('subscribe').'</button>';
  		$data['subscribers']    = ($subscribers >= 1) ? $subscribers-1 : 0;
  		$data['status'] 		= 1;    
    } else {
  		$data['msg']	= 'Invalid request (action)!';
    }

    
    
	return json_encode($data);
}
