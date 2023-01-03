<?php
function ajax_plugin_chat_block()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '', 'class' => 'alert-danger', 'friends' => 0);
	
    VLanguage::load('frontend.profile');
    
    if (!isset($_POST['blocked_id']) or !isset($_POST['action'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
  		$data['msg']	= 'Invalid request (login)!';
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $blocked_id	= $filter->get('blocked_id', 'INT');
    $action		= $filter->get('action');

    $bmodel		= VModel::load('block', 'profile');
    if ($action == 'add') {
  		if ($bmodel->exists($user_id, $blocked_id) === 1) {
  			$data['msg']	= 'Invalid request (already)!';
      		return json_encode($data);
  		}
  		
  		$bmodel->add($user_id, $blocked_id);
  		
  		$data['code']		= '<button id="block-del" class="btn btn-xs btn-submit btn-block" data-action="del" data-id="'.$blocked_id.'"><i class="fa fa-minus"></i> '.__('unblock').'</button>';
  		$data['friends']	= $friends+1;
  		$data['status']		= 1;
    } elseif ($action == 'del') {
  		if (!$bmodel->exists($user_id, $blocked_id) === 1) {
      		$data['msg']    = 'Invalid request (exists)!';
      		return json_encode($data);
  		}

  		$bmodel->del($user_id, $blocked_id);
        
  		$data['code']   	= '<button id="block-add" class="btn btn-xs btn-submit btn-block" data-action="add" data-id="'.$blocked_id.'"><i class="fa fa-plus"></i> '.__('block').'</button>';
  		$data['friends']    = ($friends >= 1) ? $friends-1 : 0;
  		$data['status'] 	= 1;    
    } else {
  		$data['msg']	= 'Invalid request (action)!';
    }
    
    
	return json_encode($data);
}
