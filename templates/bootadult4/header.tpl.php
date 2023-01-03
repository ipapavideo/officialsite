<?php defined('_VALID') or die('Restricted Access!'); $colors = (isset($_SESSION['theme'])) ? $_SESSION['theme'] : VCfg::get('template.bootadult4.colors'); $cache = VCfg::get('template.bootadult4.cache'); ?>
<!doctype html>
<html lang="<?php echo VLanguage::getCode(VLanguage::getId()); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php if (isset($this->meta_title)): echo e($this->meta_title); else: echo e(VCfg::get('site_name')); endif; ?></title>
<?php if (isset($this->meta_desc) && $this->meta_desc): ?>
  <meta name="description" content="<?php echo e($this->meta_desc); ?>" />
<?php endif; if (isset($this->meta_keys) && $this->meta_keys): ?>
  <meta name="keywords" content="<?php echo e($this->meta_keys); ?>" />
<?php endif; ?>
  <meta name="robots" content="index, follow" />
  <meta name="revisit-after" content="1 days" />
  <?php echo p('language_alt'); ?>
  <link rel="alternate" type="application/rss+xml" title="<?php echo e(VCfg::get('site_name')); ?> - RSS Feed" href="<?php echo REL_URL; ?>/rss/" />
  <?php if (isset($this->links) and $this->links): foreach ($this->links as $link): ?>
  <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php endforeach; endif; if ($metas = VCfg::get('metas')): echo $metas; endif; ?>
<?php if (isset($this->metas) && $this->metas): foreach ($this->metas as $property => $content): ?>
  <meta property="<?php echo $property; ?>" content="<?php echo $content; ?>" />
<?php endforeach; endif; if (isset($this->video) && $this->video['tags']): $tags = (is_array($this->video['tags'])) ? $this->video['tags'] : explode(',', $this->video['tags']); foreach ($tags as $tag): ?>
  <meta property="video:tag" content="<?php echo $tag; ?>" />
<?php endforeach; endif; if (isset($this->canonical)): ?>
  <link rel="canonical" href="<?php echo $this->canonical; ?>" />
<?php if (VCfg::get('mobile.redirect')): ?>
  <link rel="alternate" media="only screen and (max-width: 640px)" href="<?php echo str_replace(BASE_URL, MOBILE_URL, $this->canonical); ?>" />
<?php endif; endif; if (isset($this->prev_url)): ?><link rel="prev" href="<?php echo $this->prev_url; ?>"><?php endif; ?>
  <?php if (isset($this->next_url)): ?><link rel="next" href="<?php echo $this->next_url; ?>"><?php endif; ?>
  <?php if (VCfg::get('template.bootadult4.noblock')): ?>
<style><?php echo file_get_contents(TMP_DIR.'/cache/output/all-blocking-'.$colors.'.min.css'); ?></style><?php else: ?>
  <link href="<?php echo CDN_REL; ?>/misc/bootstrap4/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo CDN_REL; ?>/misc/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <?php if ($minify = VCfg::get('template.bootadult4.minify')): if (strpos($colors, 'light') !== false): $color = 'light'; else: $color = 'dark'; endif; ?>
  <link href="<?php echo TPL_REL; ?>/css/all-<?php echo $color; ?>.min.css?t=<?php echo $minify; ?>"  rel="stylesheet">
  <?php else: ?>
  <link href="<?php echo TPL_REL; ?>/css/style.css?t=<?php echo $cache; ?>"  rel="stylesheet">
  <link href="<?php echo TPL_REL; ?>/css/responsive.css?t=<?php echo $cache; ?>" rel="stylesheet">
  <link href="<?php echo TPL_REL; ?>/css/theme-<?php echo $colors; ?>.css?t=<?php echo $cache; ?>"  rel="stylesheet">
  <link href="<?php echo CDN_REL; ?>/misc/overlay-scrollbars/css/OverlayScrollbars.min.css" rel="stylesheet">
  <link href="<?php echo CDN_REL; ?>/misc/jquery-growl/jquery.growl.css" rel="stylesheet">
  <?php endif; if (isset($this->css)): foreach ($this->css as $url): ?><link href="<?php echo $url; ?>"  rel="stylesheet"><?php endforeach; endif; ?>
  <?php endif; ?>
  <?php if ($js = VCfg::get('template.bootadult4.javascript_code')): echo $js; endif; ?>  
</head>
<body>
  <div class="header">
	<div class="container-fluid">
	  <div class="d-flex mobile-header">
		<div id="mobile-menu" class="mt-2 justify-content-start">
		  <button class="menu-offcanvas btn btn-mobile"><i class="fa fa-bars toggler"></i></button>
		  <button class="menu-search btn btn-mobile ml-2"><i class="fa fa-search toggler"></i></button>
		</div>		
		<div class="logo mt-2 pr-0 pr-md-5">
		  <a href="<?php echo REL_URL.LANG; ?>/" title="<?php echo VCfg::get('site_name'); ?>"><img src="<?php if ($logo_url = VCfg::get('template.bootadult4.logo_url')): echo $logo_url; else: echo TPL_REL,'/images/logo.png?t='.VCfg::get('template.bootadult4.logo_time'); endif; ?>" alt="<?php echo VCfg::get('site_name'); ?>"></a>	  
		</div>
		<?php $icons = array('video' => 'video-camera', 'photo' => 'photo', 'model' => 'female', 'user' => 'users', 'blog' => 'file-text-o', 'game' => 'gamepad', 'forum' => 'list-alt', 'premium' => 'heart');
    	$translations = array('video' => __('videos'), 'photo' => __('photos'), 'model' => __('models'), 'user' => __('users'), 'blog' => __('blogs'), 'game' => __('games'), 'forum' => __('forum'), 'premium' => __('premium'));
    	if (isset($this->menu) && isset($icons[$this->menu])): $action = $this->menu; $icon = $icons[$this->menu]; $translation = $translations[$this->menu]; else: $action = 'video'; $icon = 'video-camera'; $translation = __('videos'); endif; ?>
		<div class="search pt-0 pt-md-3 mr-0 mr-md-5 d-none">
    	  <form id="search-form" method="get" action="<?php echo REL_URL,'/search/',$action; ?>/">
		  <div class="input-group">
			<input name="s" type="text" class="form-control rounded-left-pill border-right-0" placeholder="<?php echo __('search'); ?>" value="<?php if (isset($this->query) && $this->query): echo e($this->query); endif; ?>">
			<div class="input-group-append">
			  <div class="dropdown">
				<button class="btn btn-search-dropdown border-left-0 border-right-0 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  <i id="search-icon" class="fa fa-<?php echo $icon; ?>"></i> <span class="search-icon"><?php echo $translation; ?></span>
				</button>
				<div class="dropdown-menu dropdown-menu-right">
				  <?php foreach ($icons as $module => $icon): if (VModule::enabled($module)): ?>
            	  <a href="#search-<?php echo $module; ?>" data-in="<?php echo $module; ?>" class="dropdown-item<?php if ($action == $module): echo ' active'; endif; ?>"><i class="fa fa-<?php echo $icon; ?>"></i> <?php echo $translations[$module]; ?></a>
            	  <?php endif; endforeach; ?>
				</div>
			  </div>
			  <button class="btn btn-search rounded-right-pill"><i class="fa fa-search"></i></button>
			</div>
		  </div>
		  </form>
		</div>
		<div id="top-menu" class="mt-2 mt-lg-3 flex-grow-1 justify-content-end text-right">
		  <?php if (VCfg::get('multi_language')): echo p('language'); endif; ?>
		  <?php if (VAuth::loggedin()): ?>
		  <?php $requests = p('requests'); $messages = p('messages', VSession::get('user_id')); $icon = ($messages > 0) ? 'envelope-o' : 'envelope-open-o'; ?>
		  <a href="<?php echo REL_URL.LANG; ?>/message/inbox/" class="btn btn-light rounded-pill d-none d-lg-inline-block"><i class="fa fa-<?php echo $icon; ?>"></i> <?php echo __('inbox'); ?><?php if ($messages > 0): ?> <span class="badge"><?php echo $messages; ?></span><?php endif; ?></a>
		  <div class="btn-group">
		    <button class="btn btn-light rounded-pill dropdown-toggle btn-mobile" id="my-dashboard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
			  <img src="<?php echo USER_URL,'/',avatar(true); ?>" alt="" class="rounded" width="20"><span class="d-none d-lg-inline-block">&nbsp;<?php echo __('my-dashboard'); ?></span><?php if ($requests): ?> <span class="badge badge-pill badge-primary"><?php echo $requests; ?></span><?php endif; ?>
			</button>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dashboard">
              <?php $submenu = (isset($this->submenu)) ? $this->submenu : false; ?>
              <a href="<?php echo REL_URL.LANG; ?>/user/dashboard/" class="dropdown-item<?php if ($submenu == 'user-dashboard'): echo ' active'; endif; ?>"><?php echo __('my-dashboard'); ?><?php if ($requests): ?> <span class="badge badge-pill badge-primary"><?php echo $requests; ?></span><?php endif; ?></a>
              <a href="<?php echo REL_URL.LANG; ?>/user/feed/" class="dropdown-item<?php if ($submenu == 'user-feed'): echo ' active'; endif; ?>"><?php echo __('my-feed'); ?></a>
              <a href="<?php echo REL_URL.LANG; ?>/users/<?php echo e(VSession::get('username')); ?>/" class="dropdown-item<?php if ($submenu == 'profile'): echo ' active'; endif; ?>"><?php echo __('my-profile'); ?></a>
              <div class="dropdown-divider"></div>
              <a href="<?php echo REL_URL.LANG; ?>/user/videos/" class="dropdown-item<?php if ($submenu == 'user-videos'): echo ' active'; endif; ?>"><?php echo __('my-videos'); ?></a>
              <?php if (VModule::enabled('photo')): ?>
              <a href="<?php echo REL_URL.LANG; ?>/user/albums/" class="dropdown-item<?php if ($submenu == 'user-albums'): echo ' active'; endif; ?>"><?php echo __('my-albums'); ?></a>
              <?php endif; ?>
              <a href="<?php echo REL_URL.LANG; ?>/user/comments/" class="dropdown-item<?php if ($submenu == 'user-comments'): echo ' active'; endif; ?>"><?php echo __('my-comments'); ?></a>
              <div class="dropdown-divider"></div>
              <a href="<?php echo REL_URL.LANG; ?>/user/logout/" class="dropdown-item"><?php echo __('logout'); ?></a>
            </div>
          </div>
		  <?php else: ?>
		  <div class="btn-group ml-2 d-inline-block d-lg-none">
			<button class="btn btn-mobile dropdown-toggle" id="user-links" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button"><i class="fa fa-user"></i></button>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-links">
			  <a href="<?php echo REL_URL; ?>/user/login/" class="dropdown-item login"><i class="fa fa-sign-in"></i> <?php echo __('login'); ?></a>
			  <a href="<?php echo REL_URL; ?>/user/signup/" class="dropdown-item"><i class="fa fa-user-plus"></i> <?php echo __('sign-up'); ?></a>
			</div>
		  </div>
		  <a href="<?php echo REL_URL; ?>/user/login/" class="btn btn-light rounded-pill login ml-2 d-none d-lg-inline-block"><i class="fa fa-sign-in"></i> <?php echo __('login'); ?></a>
		  <a href="<?php echo REL_URL; ?>/user/signup/" class="btn btn-primary rounded-pill ml-2 d-none d-lg-inline-block"><i class="fa fa-user-plus"></i> <?php echo __('sign-up'); ?></a>
		  <?php endif; if (strpos($colors, 'dark') !== false): ?>
		  <a href="#change-colors" id="change-colors" class="btn btn-light rounded-pill btn-mobile ml-1" data-theme="light"><i class="fa fa-sun-o"></i></a>
		  <?php else: ?>
		  <a href="#change-colors" id="change-colors" class="btn btn-light rounded-pill btn-mobile ml-1" data-theme="dark"><i class="fa fa-moon-o"></i></a>
		  <?php endif; ?>
		</div>
	  </div>
	</div>
  </div>
  <div id="menu">
	<div class="container-fluid">
	  <nav id="main-menu" class="menu">
		<ul>
		  <?php if (VCfg::get('template.bootadult4.menu') == 'classic'): echo p('menu_main', $this->menu); else: echo p('menu_main_content', $this->menu); endif; ?>
		</ul>
	  </nav>
	</div>
  </div>
  <div class="container-fluid main-content mt-3">
	<?php echo $this->fetch('_errors'),$this->fetch('_warnings'),$this->fetch('_messages'); ?>
	<?php if ($adv = p('adv', 'header')): ?>
	<div class="w-100 text-center"><?php echo $adv; ?></div>
	<?php endif; ?>
