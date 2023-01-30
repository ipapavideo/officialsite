<?php
function template_plugin_users_list($users, $id = null)
{
	$lazy           = VCfg::get('template.bootadult4.lazy');
	$ids			= array();	
    $output   		= array('<div class="d-flex flex-row flex-lg-column flex-wrap">');

    foreach ($users as $user) {
        $user_id    = $user['user_id'];
        $username   = e($user['username']);
        $url        = REL_URL.LANG.'/users/'.$username.'/';
        $thumb      = USER_URL.'/'.avatar(false, $user_id, $user['avatar'], $user['gender'], false);
        $data_src   = ($lazy) ? ' data-src="'.$thumb.'"' : '';
        $thumb      = ($lazy) ? USER_URL.'/loading.gif' : $thumb;
        $lazyc      = ($lazy) ? ' lazy' : '';

        $output[]   = '<div class="media mb-2 flex-even">';
        $output[]   = '<a href="'.$url.'" title="'.__('user-profile', $username).'"><img src="'.$thumb.'"'.$data_src.' alt="'.__('user-avatar', $username).'" class="rounded mr-2'.$lazyc.'" width="50"></a>';
        $output[]   = '<div class="media-body">';
        $output[]   = '<h6 class="mb-0"><a href="'.$url.'" title="'.__('user-profile', $username).'">'.$username.'</a></h6>';
        $output[]   = '<small class="text-muted d-block">'.__('popularity').': <strong>'.VText::formatNum($user['popularity']).'</strong></small>';
        $output[]   = '<small class="text-muted d-block">'.__('subscribers').': <strong>'.VText::formatNum($user['subscribers']).'</strong></small>';
        $output[]   = '</div>';
        $output[]   = '</div>';
    }

    $output[]   = '</div>';
	
	return implode("\n", $output);
}
