<?php
function template_plugin_menu_main($current)
{
	$lmodel	= VModel::load('menu', 'core');
	$links	= $lmodel->links('main');
	
	$language		= VLanguage::getLanguage();
	$orientation 	= orientation();
	$menu 			= array();
	foreach ($links as $index => $link) {
		$orientation	= ($link['type'] == 'int' and $link['orientation'] == '1') ? ORIENTATION : '';
		$url			= ($link['type'] == 'int') ? REL_URL.LANG.$orientation.$link['url'] : $link['url'];
		$target			= ($link['target'] != '0') ? ' target="_blank"' : '';
		$active 		= ($link['current'] == $current) ? ' active' : '';
		$title			= ($link['title'] != '') ? ' title="'.htmlspecialchars($link['title'], ENT_QUOTES, 'UTF-8', false).'"' : '';
		$name			= ($language == 'en') ? $link['name'] : __($link['trans']);
		$name			= htmlspecialchars($name, ENT_QUOTES, 'UTF-8', false);
		$icon			= ($link['icon'] != '') ? '<i class="fa fa-'.$link['icon'].' fa-block"></i> ' : '';
		$rel			= ($link['nofollow'] == '1') ? ' rel="nofollow"' : '';
		$parent_id		= $link['parent_id'];
		$prev			= ($index > 0) ? $index-1 : null;
		$next			= $index+1;
		$class			= ' class="menu-list"';
		
		if ($parent_id == '0' and $link['children'] > 0) {
			$menu[]		= '<li class="parent"><a href="'.$url.'"'.$title.$target.$rel.' class="menu-item'.$active.'">'.$icon.$name.' <i class="fa fa-angle-down toggler"></i></a>';
			$menu[]		= '<ul'.$class.'>';
		} elseif ($parent_id != '0') {
			$menu[]		= '<li><a href="'.$url.'"'.$title.$target.$rel.'>'.$icon.$name.'</a></li>';
			if (!isset($links[$next]) or (isset($links[$next]) and $links[$next]['parent_id'] == '0')) {
				$menu[]	= '</ul></li>';
			}
		} else {
			$menu[]		= '<li><a href="'.$url.'"'.$title.$target.$rel.' class="menu-item'.$active.'">'.$icon.$name.'</a></li>';
		}						
	}
	
	if (VCfg::get('video.upload')) {	
		$menu[]	= '<li class="item-right upload"><a href="'.REL_URL.'/upload/" class="btn btn-sm btn-primary rounded-pill"><i class="fa fa-upload"></i> '.__('upload').'</a></li>';
	}

	
	return implode("\n", $menu);
}
