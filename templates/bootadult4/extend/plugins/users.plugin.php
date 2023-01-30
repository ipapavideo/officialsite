<?php
function template_plugin_users($users, $id = null, $colmenu = null, $submenu = null, $requests = null, $class = 'users')
{
	$lazy           = VCfg::get('template.bootadult4.lazy');
	$online_expire 	= VCfg::get('user.online_expire');
	$online 		= time()-$online_expire;
	
	$ids			= array();
	$output			= array('<div class="grid mx-auto '.$class.'">');
	
	foreach ($users as $user) {
		$user_id	= $user['user_id'];
		$username	= e($user['username']);
		$url		= REL_URL.LANG.'/users/'.$username.'/';
		$thumb		= USER_URL.'/'.avatar(false, $user_id, $user['avatar'], $user['gender'], false);
        $data_src   = ($lazy) ? ' data-src="'.$thumb.'"' : '';
        $thumb      = ($lazy) ? USER_URL.'/loading.gif' : $thumb;
        $lazyc      = ($lazy) ? ' lazy' : '';		
		
		$output[]	= '<div id="user-'.$user_id.'" class="cell user">';
		$output[]	= '<div class="user-thumb">';
		$output[]	= '<a href="'.$url.'" title="'.__('user-profile', $username).'" rel="nofollow"><img src="'.$thumb.'"'.$data_src.' alt="'.__('user-avatar', $username).'" class="thumb rounded'.$lazyc.'"></a>';
		
		if ($user['online'] > $online) {
			$output[]	= '<div class="user-info user-online"><i class="text-success fa fa-circle-o"></i> '.__('online').'</div>';
		}

		$output[]	= '</div>';
		
		$output[]	= '<h5 class="user-name"><a href="'.$url.'" title="'.__('user-profile', $username).'" rel="nofollow">'.$username.'</a></h5>';
		
		if ($requests or $colmenu) {
			$output[]   = '<div class="text-center mb-3">';
            $output[]   = '<div class="btn-group" role="group" aria-label="">';
		
			if ($requests) {
				$output[]	= '<button class="btn-remove btn btn-xs btn-success" data-action="approve" data-id="'.$user_id.'">'.__('approve').'</button>';
    			$output[]	= '<button class="btn-remove btn btn-xs btn-danger" data-action="deny" data-id="'.$user_id.'">'.__('deny').'</button>';
			}
		
			if ($colmenu) {
				$output[]	= '<button class="btn-remove btn btn-xs btn-primary" data-id="'.$user_id.'" data-sub="'.$submenu.'">'.__('remove').'</button>';
			}
			
			$output[]	= '</div></div>';
		}
		
		$output[]	= '</div>';
	}
	
	$output[]		= '</div>';
	
	return implode("\n", $output);
}
