<?php
function template_widget_topics_recent()
{
	$user_id	= (VAuth::loggedin()) ? (int) VSession::get('user_id') : 0;
	$tmodel		= VModel::load('topic', 'forum');
	$topics		= $tmodel->topics(array('status' => 1, 'order' => 'sticky'), VCfg::get('template.bootadult4.topics_recent_nr'));

    $output     = array();
    $output[]   = '<div class="row mb-3">';
    $output[]   = '<div class="col-12 text-center text-md-left">';
    $output[]   = '<h2>'.__('new-forum-topics').'</h2>';

    if ($topics) {
        $output[]   = p('topics', $topics, $user_id);
    } else {
        $output[]   = '<div class="none">'.__('no-topics').'</div>';
    }

    $output[]   = '</div></div>';
  	
  	return implode('', $output);
}
