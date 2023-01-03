<?php
function template_widget_search_popular()
{
	$pmodel	= VModel::load('popular', 'video');
	if (!$searches = $pmodel->popular(VCfg::get('template.defboot.search_popular_nr'))) {
		return;
	}

    $output     = array();
    $output[]   = '<div class="panel panel-default">';
    $output[]   = '<div class="panel-heading">';
    $output[]   = '<h3 class="panel-title"><strong>'.__('popular-searches').'</strong></h3>';
    $output[]   = '</div>';
    $output[]   = '<div class="panel-body panel-padding">';
    $output[]	= '<ul class="list-inline">';

	foreach ($searches as $row) {
		$keyword	= e(utf8_strtolower($row['keyword']));
		if ($keyword) {
			$output[]	= '<li><a href="'.REL_URL.LANG.ORIENTATION.'/search/video/?s='.str_replace(' ', '+', $keyword).'" class="btn btn-menu">'.$keyword.'</a></li>';
		}
	}

    $output[]   = '</ul></div></div>';

    return implode('', $output);	
}