<?php
function template_plugin_menu_footer()
{
	$lmodel	= VModel::load('menu', 'core');
	$links	= $lmodel->links('footer');
	
	$tpl 		= VF::factory('template');
	$language	= VLanguage::getLanguage();
	$type		= VCfg::get('template.defboot.footer');
	$menu 		= array();
	
	if ($type == 'columns') {
		$menu[]	= '<div class="row">';
	} else {
		$menu[]	= '<ul class="footer">';
	}
	
	
	foreach ($links as $index => $link) {
		if ($type == 'list' and $link['type'] == '2') {
			continue;
		}
		
		$parent_id	= $link['parent_id'];
		$parent		= $parent_id;
		if ($type == 'columns' and $parent_id == '0') {
			$menu[]	= '<div class="col-sm-4 col-md-4">';
			$menu[]	= '<ul class="list-footer">';
		}	
	
		$name	= ($language == 'en') ? $link['name'] : __($link['trans']);
		if ($link['type'] == '2') {
			$menu[]	= '<li class="list-header">'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8', false).'</li>';
		} else {
			$url	= ($link['type'] == 'int') ? REL_URL.$link['url'] : $link['url'];
			$target	= ($link['target'] != 'none') ? ' target="_'.$link['target'].'"' : '';
			$active = ($link['current'] == $tpl->menu) ? ' class="active"' : '';
			$title	= ($link['title'] != '') ? ' title="'.htmlspecialchars($link['title'], ENT_QUOTES, 'UTF-8', false).'"' : '';
			$icon	= ($link['icon'] != '') ? '<i class="fa fa-'.$link['icon'].'"></i> ' : '';
			$rel    = ($link['nofollow'] == '1') ? ' rel="nofollow"' : '';
			$class	= ($link['class'] != '') ? ' class="'.$link['class'].'"' : '';
			$id		= ' id="categories-dropdown"';
		
			$menu[]	= '<li'.$active.'><a href="'.$url.'"'.$title.$target.$class.$rel.'>'.$icon.htmlspecialchars($name, ENT_QUOTES, 'UTF-8', false).'</a></li>';
		}

		if ($type == 'columns') {
			$next	= $index+1;
			if ((isset($links[$next]) and $links[$next]['parent_id'] == '0') or !isset($links[$next])) {
				$menu[]	= '</ul></div>';
			}
		}
	}

	if ($type == 'columns') {
		$menu[]	= '</div>';
	} else {
		$menu[]	= '</ul>';
	}
	
	return implode("\n", $menu);
}
