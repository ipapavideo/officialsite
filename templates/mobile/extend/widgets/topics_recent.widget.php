<?php
function template_widget_topics_recent()
{
	$tmodel	= VModel::load('topic', 'forum');
	$topics	= $tmodel->topics(array('status' => 1, 'order' => 'sticky'), VCfg::get('template.defboot.topics_recent_nr'));
	
	$output		= array();
	$output[]	= '<div class="panel panel-default">';
    $output[]	= '<div class="panel-heading">';
    $output[]	= '<h3 class="panel-title"><strong>'.__('new-forum-topics').'</strong></h3>';
    $output[]	= '</div>';
    $output[]	= '<div class="panel-body">';
    
    if ($topics) {
  		if (!function_exists('display_topics')) {
  			require BASE_DIR.'/templates/defboot/extend/functions/topic.php';
  		}
  		
  		$output[]	= display_topics($topics);
  	} else {
  		$output[]	= '<div class="none">'.__('no-topics').'</div>';
  	}
  	
  	$output[]	= '</div></div>';
  	
  	return implode('', $output);
}