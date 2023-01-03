<?php
function display_users($users, $id = null, $class = null)
{
    $id         = ($id) ? '-'.$id : '';
    $ids        = array();
    $class      = ($class) ? ' '.$class : '';
	$online		= time()-VCfg::get('user.online_expire');

    $output     = array();
    $output[]   = '<ul class="users'.$class.'">';
    
    foreach ($users as $user) {
  		$username	= e($user['username']);
  		
  		$output[]	= '<li id="user-'.$user['user_id'].$id.'" class="user">';
  		$output[]	= '<a href="'.REL_URL.LANG.'/users/'.$username.'/" title="'.__('user-profile', $username).'" rel="nofollow">';
  		$output[]	= '<div class="user-thumb">';
  		$output[]	= '<img src="'.USER_URL.'/'.avatar(false, $user['user_id'], $user['avatar'], $user['gender'], true).'" alt="'.__('user-avatar', $username).'">';
  		
  		if ($user['online'] > $online) {
  			$output[]	= '<span class="user-online"><i class="text-success fa fa-circle-o"></i> '.__('online').'</span>';
  		}
  		
  		$output[]	= '</div>';
  		$output[]	= '</a>';
  		$output[]	= '<span class="user-title"><a href="'.REL_URL.LANG.'/users/'.$username.'" title="'.__('user-profile', $username).'" rel="nofollow">'.$username.'</a></span>';
  		$output[]	= '</li>';
    }
    
	$output[]	= '</ul>';
	
	return implode('', $output);
}
