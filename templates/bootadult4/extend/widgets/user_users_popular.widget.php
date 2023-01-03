<?php
function template_widget_user_users_popular()
{
    $umodel     = VModel::load('community', 'user');
    $users      = $umodel->users(array('orientation' => orientation(), 'has_avatar' => 'all', 'order' => 'popular'), 10);
	
	$output		= array();
	$output[]	= '<div class="d-none d-lg-block">';
	$output[]	= '<hr width="90%">';
	$output[]	= '<div class="w-100 font-weight-bold text-muted mb-2">'.__('viewed').' '.__('users').'</div>';
	$output[]	= p('users_list', $users);
	$output[]	= '<div class="text-center"><a href="'.REL_URL.LANG.'/user/search/?order=popular" class="btn btn-sm btn-primary">'.__('view-all').'</a></div>';
	$output[]	= '</div>';
	
	return implode("\n", $output);
}
