<?php
function template_widget_tags_popular()
{
	$cache	= VF::factory('cache');
	if (!$tags = $cache->get('tags-popular', 1440)) {
		$tmodel	= VModel::load('tag', 'tools', true);
		$tags	= $tmodel->tags(array('t.tag'), null, null, null, VCfg::get('template.bootadult4.tags_popular_nr'), 't.videos', 'DESC');
		if ($tags) {
			$cache->set('tags-popular', $tags, 1440);
		}
	}
	
	if (!$tags) {
		return;
	}
	
    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12 d-flex flex-wrap justify-content-center justify-content-md-left">';
    $output[]   = '<h2 class="w-100">'.__('popular-tags').'</h2>';
    
    $url		= REL_URL.LANG.ORIENTATION;
    $url		= (VCfg::get('video.comp_url')) ? $url.'/video/tag/' : $url.'/tag/';

	foreach ($tags as $row) {
		$tag		= e(utf8_trim(utf8_strtolower($row['tag'])));
		if ($tag) {
			$output[]	= '<a href="'.$url.prepare_string($tag, true).'/"  class="badge badge-secondary p-2 m-1">'.$tag.'</a>';
		}
	}

    $output[]   = '</div></div>';

    return implode('', $output);	
}