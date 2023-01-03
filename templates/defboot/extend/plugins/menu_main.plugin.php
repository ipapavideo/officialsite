<?php
function template_plugin_menu_main($current)
{
	$lmodel	= VModel::load('menu', 'core');
	$links	= $lmodel->links('main');
	
	$language	= VLanguage::getLanguage();
	$menu 		= array();
	foreach ($links as $index => $link) {
		$orientation	= ($link['type'] == 'int' and $link['orientation'] == '1') ? ORIENTATION : '';
		$url			= ($link['type'] == 'int') ? REL_URL.LANG.$orientation.$link['url'] : $link['url'];
		$target			= ($link['target'] != '0') ? ' target="_blank"' : '';
		$active 		= ($link['current'] == $current) ? ' class="active"' : '';
		$title			= ($link['title'] != '') ? ' title="'.htmlspecialchars($link['title'], ENT_QUOTES, 'UTF-8', false).'"' : '';
		$name			= ($language == 'en') ? $link['name'] : __($link['trans']);
		$name			= htmlspecialchars($name, ENT_QUOTES, 'UTF-8', false);
		$icon			= ($link['icon'] != '') ? '<i class="fa fa-'.$link['icon'].' fa-block"></i>' : '';
		$rel			= ($link['nofollow'] == '1') ? ' rel="nofollow"' : '';
		$parent_id		= $link['parent_id'];
		$prev			= ($index > 0) ? $index-1 : null;
		$next			= $index+1;
		
		if ($parent_id == '0' and $link['children'] > 0) {
			$menu[]		= '<li'.$active.'><a href="'.$url.'"'.$title.$target.$rel.'>'.$icon.$name.' <i class="fa fa-angle-down"></i></a>';
			$menu[]		= '<ul><li>';
		} elseif ($parent_id != '0') {
			$menu[]		= '<a href="'.$url.'"'.$title.$target.$rel.'>'.$icon.$name.'</a>';
			if (!isset($links[$next]) or (isset($links[$next]) and $links[$next]['parent_id'] == '0')) {
				$menu[]	= '</li></ul></li>';
			}
		} elseif ($link['class'] == 'categories-dropdown') {
			$orientation	= orientation();			
			$cmodel			= VModel::load('category', 'video');
			$categories		= $cmodel->categories($orientation, 'featured', 9);
			if ($categories) {			
				$menu[]		= '<li'.$active.'><a href="'.$url.'"'.$title.$target.$rel.'>'.$icon.$name.' <i class="fa fa-angle-down fa-categories"></i></a>';
				$menu[]		= '<ul class="categories-dropdown"><li>';
			
				foreach ($categories as $category) {				  
					$menu[]	= '<a href="'.video_category_url($category['slug']).'"><img src="'.MEDIA_REL.'/videos/cat/'.$category['cat_id'].'.'.$category['ext'].'" alt="'.__('category-image', e($category['name'])).'" width="100"><br>'.e($category['name']).'</a>';
				}
			
				$menu[]	= '<a href="'.REL_URL.LANG.'/categories/" class="see-more"><i class="fa fa-arrow-circle-o-right fa-5x"></i>'.__('see-more').'</a>';
				$menu[]		= '</li></ul></li>';
			} else {
				$menu[]     = '<li'.$active.'><a href="'.$url.'"'.$title.$target.$rel.'>'.$icon.$name.'</a></li>';
			}
		} else {
			$menu[]		= '<li'.$active.'><a href="'.$url.'"'.$title.$target.$rel.'>'.$icon.$name.'</a></li>';
		}						
	}
	
	if (VCfg::get('video.upload')) {	
		$menu[]	= '<li class="upload"><a href="'.REL_URL.'/upload/" class="btn btn-menu btn-upload"><i class="fa fa-upload"></i> '.__('upload').'</a></li>';
	}
	
	return implode('', $menu);
}
