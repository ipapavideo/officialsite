<?php
function template_plugin_menu_main_content($current)
{
	$lmodel	= VModel::load('menu', 'core');
	$links	= $lmodel->links('main_content');
	
	$videos_url		= video_url();
	$models_url		= models_url();
	$photos_url		= photos_url();
	
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
		
		if ($link['current'] == 'video') {
			$menu[]		= '<li>';
			$menu[]		= '<a href="'.$url.'"'.$title.$target.$rel.' class="menu-item'.$active.'">'.$icon.$name.' <i class="fa fa-angle-down toggler hidden-mobile"></i></a>';
			$menu[]		= '<div class="mega-menu">';
			$menu[]		= '<div class="row px-2 py-3">';
			$menu[]		= '<div class="col-3 col-lg-2 menu-left">';
			
			$orders		= VData::get('orders', 'video');
			$icons		= VData::get('orders_icons', 'video');
			
			foreach ($orders as $order => $name) {
				$menu[]	= '<a href="'.$videos_url.'/'.$order.'/"><i class="fa fa-'.$icons[$order].'"></i> '.e($name).'</a>';
			}
			
			$menu[]		= '</div>';
			$menu[]		= '<div class="menu-content col-9 col-lg-10">';
			
            $vmodel 	= VModel::load('video', 'video');
            $videos 	= $vmodel->videos(array('orientation' => $orientation, 'timeline' => 'month', 'order' => 'viewed'), 5);
            $menu[] 	= '<div class="h3 w-100">热门视频</div>';
            $menu[] 	= p('videos', $videos, '-menu-viewed', null, null, false, true, 'videos-menu');
            $menu[] 	= '<div class="py-2 text-center"><a href="'.video_url().'/viewed/month/" class="btn btn-primary px-3 py-1">'.__('view-more').'</a></div>';
			
			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</li>';
		} elseif ($link['current'] == 'photo') {
			$menu[]		= '<li>';
			$menu[]		= '<a href="'.$url.'"'.$title.$target.$rel.' class="menu-item'.$active.'">'.$icon.$name.' <i class="fa fa-angle-down toggler hidden-mobile"></i></a>';
			$menu[]		= '<div class="mega-menu">';
			$menu[]		= '<div class="row px-2 py-3">';
			$menu[]		= '<div class="col-3 col-lg-2 menu-left">';
			
			$orders		= VData::get('orders', 'photo');
			$icons		= VData::get('orders_icons', 'photo');
			
			foreach ($orders as $order => $name) {
				$menu[]	= '<a href="'.$photos_url.'/'.$order.'/"><i class="fa fa-'.$icons[$order].'"></i> '.e($name).'</a>';
			}
			
			$menu[]		= '</div>';
			$menu[]		= '<div class="col-9 col-lg-10 menu-content">';
			
            $amodel 	= VModel::load('album', 'photo');
            $albums		= $amodel->albums(array('orientation' => $orientation, 'order' => 'viewed', 'timeline' => 'week'), 6);
            
            $menu[] 	= '<div class="h3 w-100">热门相册</div>';
            $menu[] 	= p('albums', $albums, '-menu-albums', false, true, 'albums-menu');
            $menu[] 	= '<div class="py-2 text-center"><a href="'.$photos_url.'/viewed/week/" class="btn btn-primary px-3 py-1">'.__('view-more').'</a></div>';
			
			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</li>';
		} elseif ($link['current'] == 'category') {
			$menu[]		= '<li>';
			$menu[]		= '<a href="'.$url.'"'.$title.$target.$rel.' class="menu-item'.$active.'">'.$icon.$name.' <i class="fa fa-angle-down toggler hidden-mobile"></i></a>';
			$menu[]		= '<div class="mega-menu">';
			$menu[]		= '<div class="row px-2 py-3">';
			$menu[]		= '<div class="col-3 col-lg-2 menu-left">';
			
			$orders		= VData::get('orders_categories', 'video');
			$icons		= VData::get('orders_categories_icons', 'video');
			
			foreach ($orders as $order => $name) {
				$menu[]	= '<a href="'.REL_URL.LANG.'/categories/?order='.$order.'"><i class="fa fa-'.$icons[$order].'"></i> '.e($name).'</a>';
			}
			
			$menu[]		= '</div>';
			$menu[]		= '<div class="col-9 col-lg-10 menu-content">';
			
            $cmodel     = VModel::load('category', 'video');
            $categories	= $cmodel->categories($orientation, 'popular', 6);

            $menu[] 	= '<div class="h3 w-100">热门分类</div>';
            $menu[] 	= p('categories', $categories, 'video', false, false, 'categories-menu');
            $menu[] 	= '<div class="py-2 text-center"><a href="'.REL_URL.LANG.'/categories/" class="btn btn-primary px-3 py-1">'.__('view-more').'</a></div>';

			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</li>';
		} elseif ($link['current'] == 'channel') {
			$menu[]		= '<li>';
			$menu[]		= '<a href="'.$url.'"'.$title.$target.$rel.' class="menu-item'.$active.'">'.$icon.$name.' <i class="fa fa-angle-down toggler hidden-mobile"></i></a>';
			$menu[]		= '<div class="mega-menu">';
			$menu[]		= '<div class="row px-2 py-3">';
			$menu[]		= '<div class="col-3 col-lg-2 menu-left">';
			
			$orders		= VData::get('orders', 'channel');
			$icons		= VData::get('orders_icons', 'channel');
			
			foreach ($orders as $order => $name) {
				$menu[]	= '<a href="'.REL_URL.LANG.'/channels/'.$order.'/"><i class="fa fa-'.$icons[$order].'"></i> '.e($name).'</a>';
			}
			
			$menu[]		= '</div>';
			$menu[]		= '<div class="col-9 col-lg-10 menu-content">';
			
            $cmodel     = VModel::load('channel', 'channel');
            $channels   = $cmodel->channels(array(), $orientation, 'all', 'viewed', 'week', 5);
            $menu[] 	= '<div class="h3 w-100">热门频道</div>';
            $menu[] 	= p('channels', $channels, '-menu-channels', 'channels-menu');
            $menu[] 	= '<div class="py-2 text-center"><a href="'.REL_URL.LANG.'/channels/" class="btn btn-primary px-3 py-1">'.__('view-more').'</a></div>';

			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</li>';
		} elseif ($link['current'] == 'model') {
			$menu[]		= '<li>';
			$menu[]		= '<a href="'.$url.'"'.$title.$target.$rel.' class="menu-item'.$active.'">'.$icon.$name.' <i class="fa fa-angle-down toggler hidden-mobile"></i></a>';
			$menu[]		= '<div class="mega-menu">';
			$menu[]		= '<div class="row px-2 py-3">';
			$menu[]		= '<div class="col-3 col-lg-2 menu-left">';
			
			$orders		= VData::get('orders', 'model');
			$icons		= VData::get('orders_icons', 'model');
			
			foreach ($orders as $order => $name) {
				$menu[]	= '<a href="'.$models_url.$order.'/"><i class="fa fa-'.$icons[$order].'"></i> '.e($name).'</a>';
			}
			
			$menu[]		= '</div>';
			$menu[]		= '<div class="col-9 col-lg-10 menu-content">';
			
            $mmodel     = VModel::load('model', 'model');
            $opts		= array('letter' => 'all', 'order' => 'popular', 'timeline' => 'week');
            $models		= $mmodel->models($opts, 5);

            $menu[] 	= '<div class="h3 w-100">Popular Models</div>';
            $menu[] 	= p('models', $models, '-menu-models');
            $menu[] 	= '<div class="py-2 text-center"><a href="'.$models_url.'popular/" class="btn btn-primary px-3 py-1">'.__('view-more').'</a></div>';

			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</li>';
		} elseif ($link['current'] == 'community') {
			$menu[]		= '<li>';
			$menu[]		= '<a href="'.$url.'"'.$title.$target.$rel.' class="menu-item'.$active.'">'.$icon.$name.' <i class="fa fa-angle-down toggler hidden-mobile"></i></a>';
			$menu[]		= '<div class="mega-menu">';
			$menu[]		= '<div class="row px-2 py-3">';
			$menu[]		= '<div class="col-3 col-lg-2 menu-left">';
			
			$entries	= array('/community/' => __('news-feed'), '/user/members/' => __('profiles'), '/user/search/' => __('members-search'));
			$icons		= array('/community/' => 'rss', '/user/members/' => 'users', '/user/search/' => 'user');
			
			foreach ($entries as $order => $name) {
				$menu[]	= '<a href="'.REL_URL.LANG.$order.'/"><i class="fa fa-'.$icons[$order].'"></i> '.e($name).'</a>';
			}
			
			$menu[]		= '</div>';
			$menu[]		= '<div class="col-9 col-lg-10 menu-content">';
			
  			$umodel     = VModel::load('community', 'user');
  			$users      = $umodel->users(array('orientation' => $orientation, 'has_avatar' => 'all', 'order' => 'popular'), 10);
			
            $menu[] 	= '<div class="h3 w-100">活跃用户</div>';
            $menu[] 	= p('users', $users, '-menu-users', null, null, null, 'users-menu');
            $menu[] 	= '<div class="py-2 text-center"><a href="'.REL_URL.LANG.'/user/members/" class="btn btn-primary px-3 py-1">'.__('view-more').'</a></div>';

			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</div>';
			$menu[]		= '</li>';
		} else {
			$menu[]		= '<li><a href="'.$url.'"'.$title.$target.$rel.' class="menu-item'.$active.'">'.$icon.$name.'</a></li>';
		}
	}
	
	if (VCfg::get('video.upload')) {	
		$menu[]	= '<li class="item-right upload"><a href="'.REL_URL.'/upload/" class="btn btn-sm btn-primary rounded-pill menu-item"><i class="fa fa-upload"></i> '.__('upload').'</a></li>';
	}

	
	return implode("\n", $menu);
}
