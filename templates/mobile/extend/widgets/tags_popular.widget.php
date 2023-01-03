<?php
function template_widget_tags_popular()
{
	$cache	= VF::factory('cache');
	if (!$tags = $cache->get('tags-popular', 1440)) {
		$tmodel	= VModel::load('tag', 'tools', true);
		$tags	= $tmodel->tags(array('t.tag'), null, null, null, VCfg::get('template.defboot.tags_popular_nr'), 't.videos', 'DESC');
		if ($tags) {
			$cache->set('tags-popular', $tags, 1440);
		}
	}
	
	if (!$tags) {
		return;
	}
	
    $output     = array();
    $output[]   = '<div class="panel panel-default">';
    $output[]   = '<div class="panel-heading">';
    $output[]   = '<h3 class="panel-title"><strong>'.__('popular-tags').'</strong></h3>';
    $output[]   = '</div>';
    $output[]   = '<div class="panel-body panel-padding">';
    $output[]	= '<ul class="list-inline">';
    
    $url		= REL_URL.LANG.ORIENTATION;
    $url		= (VCfg::get('video.comp_url')) ? $url.'/video/tag/' : $url.'/tag/';

	foreach ($tags as $row) {
		$tag		= e(utf8_trim(utf8_strtolower($row['tag'])));
		if ($tag) {
			$output[]	= '<li><a href="'.$url.prepare_string($tag, true).'/"  class="btn btn-menu">'.$tag.'</a></li>';
		}
	}

    $output[]   = '</ul></div></div>';

    return implode('', $output);	
}