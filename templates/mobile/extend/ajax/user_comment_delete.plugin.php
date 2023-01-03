<?php
function ajax_plugin_user_comment_delete()
{
    $data = array('status' => 0, 'code' => '', 'msg' => '', 'debug' => '');
	
    VLanguage::load('frontend.user');
    
    if (!isset($_POST['comment_id'])) {
        $data['msg'] = 'Invalid request!';
        return json_encode($data);
    }
    
    $user_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
    if (!$user_id) {
        $data['msg']	= __('comment-approve-login');
        return json_encode($data);
    }
        
    $filter		= VF::factory('filter');
    $comment_id	= $filter->get('comment_id', 'INT');
    
    $cmodel		= VModel::load('comment', 'profile');
    if (!$wall = $cmodel->wall($comment_id)) {
  		$data['msg']	= 'Invalid request (wall)!';
  		return json_encode($data);
    }
    
    if ($wall['user_id'] != $user_id) {
  		$data['msg']	= 'Invalid request (owner)!';
  		return json_encode($data);
    }
    
    if (!$comment = $cmodel->get($comment_id)) {
  		$data['msg']	= 'Invalid request (comment)!';
  		return json_encode($data);
    }
    
    if (VCfg::get('user.points')) {
        $pmodel = VModel::load('points', 'user');
    }    
    
    $wall_id	= $wall['wall_id'];
    if ($comment['parent_id'] == '0' and $comment['replies']) {
        $comments   = $cmodel->comments('c.parent_id = ? AND c.wall_id = ?', 'ii', array($comment_id, $wall_id), 65000, 'c.comment_id', 'ASC', false);
        if ($comments) {
            foreach ($comments as $reply) {
                $cmodel->del($reply['comment_id'], $wall_id, $reply['user_id']);
                if ($reply['user_id'] and isset($pmodel)) {
                    $pmodel->del($reply['user_id'], 'profile-comment-del');
                }
            }
        }
    }
    
    $cmodel->del($comment_id, $wall['wall_id'], $wall['user_id']);
    if (isset($pmodel)) {
        $pmodel->del($user_id, 'profile-comment-del');
    }
    
	$data['msg']	= __('comment-deleted');
	$data['status']	= 1;
	
	return json_encode($data);	
}
