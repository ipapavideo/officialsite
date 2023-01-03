<?php
function template_widget_links()
{
    $lmodel     = VModel::load('link', 'link');
    $links		= $lmodel->links(VCfg::get('template.defboot.links_nr'));

    if (!$links) {
        return;
    }
    
    $output     = array();
    $output[]   = '<div class="panel panel-default">';
    $output[]   = '<div class="panel-heading">';
    $output[]   = '<h3 class="panel-title"><strong>'.__('links').'</strong></h3>';
    $output[]   = '</div>';
    $output[]   = '<div class="panel-body">';

    if ($links) {
        $output[]   = '<ul class="nav nav-stacked nav-list columns">';

        foreach ($links as $link) {
      		$base_url	= (MOBILE) ? MOBILE_URL : BASE_URL;
      		$url		= ($link['hardlink']) ? $link['url'] : $base_url.'/link/out/?id='.$link['link_id'].'&url='.$link['url'];
      		$target		= ($link['target'] == '1') ? ' target="_blank"' : '';
      		$title		= ($link['description']) ? ' title="'.e($link['description']).'"' : '';
      		$name		= ($link['type'] == '1') ? '<img src="'.MEDIA_URL.'/links/'.$link['link_id'].'.'.$link['ext'].'" alt="'.e($link['title']).'">' : e($link['title']);
      		$output[]	= '<li><a href="'.$url.'"'.$title.$target.'>'.$name.'</a></li>';
        }

        $output[]   = '</ul>';
    } else {
        $output[]   = '<div class="none">'.__('no-links').'</div>';
    }

    $output[]   = '</div></div>';    
    
    return implode('', $output);
}
