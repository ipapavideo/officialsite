<?php
function template_widget_links()
{
    $lmodel     = VModel::load('link', 'link');
    $links		= $lmodel->links(VCfg::get('template.bootadult4.links_nr'));

    if (!$links) {
        return;
    }

    $output     = array();
    $output[]   = '<div class="row">';
    $output[]   = '<div class="col-lg-12">';
    $output[]   = '<h3>'.__('友情链接').'</h3>';

    if ($links) {
        $output[]   = '<ul class="list-unstyled row">';

        foreach ($links as $link) {
      		$base_url	= (MOBILE) ? MOBILE_URL : BASE_URL;
      		$url		= ($link['hardlink']) ? $link['url'] : $base_url.'/link/out/?id='.$link['link_id'].'&url='.$link['url'];
      		$target		= ($link['target'] == '1') ? ' target="_blank"' : '';
      		$title		= ($link['description']) ? ' title="'.e($link['description']).'"' : '';
      		$name		= ($link['type'] == '1') ? '<img src="'.MEDIA_URL.'/links/'.$link['link_id'].'.'.$link['ext'].'" alt="'.e($link['title']).'">' : e($link['title']);
      		
      		$output[]	= '<li class="list-item col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2"><a href="'.$url.'"'.$title.$target.'>'.$name.'</a></li>';
        }

        $output[]   = '</ul>';
    } else {
        $output[]   = '<div class="none">'.__('no-links').'</div>';
    }

    $output[]   = '</div></div>';    
    
    return implode('', $output);
}
