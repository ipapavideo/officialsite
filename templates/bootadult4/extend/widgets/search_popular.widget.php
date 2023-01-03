<?php
function template_widget_search_popular()
{
	$pmodel	= VModel::load('popular', 'video');
	if (!$searches = $pmodel->popular(VCfg::get('template.bootadult4.search_popular_nr'))) {
		return;
	}

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12 d-flex flex-wrap justify-content-center justify-content-md-left">';
    $output[]   = '<h2 class="w-100">'.__('popular-searches').'</h2>';
    
	foreach ($searches as $row) {
		$keyword	= e(utf8_strtolower($row['keyword']));
		if ($keyword) {
			$output[]	= '<a href="'.REL_URL.LANG.ORIENTATION.'/search/video/?s='.str_replace(' ', '+', $keyword).'" class="badge badge-secondary p-2 m-1">'.$keyword.'</a>';
		}
	}

    $output[]   = '</div></div>';

    return implode('', $output);	
}