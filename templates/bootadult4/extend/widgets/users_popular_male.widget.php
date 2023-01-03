<?php
function template_widget_users_popular_male()
{
	$umodel		= VModel::load('community', 'user');
	$users		= $umodel->users(array('orientation' => orientation(), 'has_avatar' => 'all', 'order' => 'popular', 'gender' => 1), VCfg::get('template.bootadult4.users_popular_male_nr'));

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-md-8 text-center text-md-left">';
    $output[]   = '<h2>'.__('popular-male-users').'</h2>';
    $output[]   = '</div>';
    $output[]   = '<div class="col-md-4 d-flex justify-content-center justify-content-lg-end align-items-center">';
    $output[]   = '<a href="'.REL_URL.LANG.'/user/search/?order=popular&gender=male" class="btn btn-light btn-sm"><i class="fa fa-plus"></i> '.__('view-more').'</a>';
    $output[]   = '</div></div>';
    
    if ($users) {
        $output[]   = p('users', $users);
    } else {
        $output[]   = '<div class="none">'.__('no-users').'</div>';
    }

    $output[]   = '</div></div>';
    
    return implode('', $output);
}