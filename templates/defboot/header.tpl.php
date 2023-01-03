<?php defined('_VALID') or die('Restricted Access!'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
  <?php if (isset($this->photo_id)): ?><link href="<?php echo PHOTO_THUMB_URL,'/',$this->photo_id; ?>.jpg" rel="image_src" /><?php endif; ?>
  <link href="<?php echo CDN_REL; ?>/misc/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo CDN_REL; ?>/misc/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <?php if ($minify = VCfg::get('template.defboot.minify')): ?>
  <link href="<?php echo TPL_REL; ?>/css/all.min.css?t=<?php echo $minify; ?>"  rel="stylesheet">  
  <?php else: ?>
  <link href="<?php echo REL_URL; ?>/misc/awesome-bootstrap-checkbox/css/awesome-bootstrap-checkbox.css"  rel="stylesheet">
  <link href="<?php echo TPL_REL; ?>/css/style.css"  rel="stylesheet">  
  <link href="<?php echo TPL_REL; ?>/css/theme-<?php echo VCfg::get('template.defboot.colors'); ?>.css"  rel="stylesheet">  
  <link href="<?php echo TPL_REL; ?>/css/responsive.css" rel="stylesheet">
  <?php endif; if (isset($this->css)): foreach ($this->css as $url): ?><link href="<?php echo $url; ?>"  rel="stylesheet"><?php endforeach; endif; ?>
  <?php if ($js = VCfg::get('template.defboot.javascript_code')): echo $js; endif; ?>
  <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->  
</head>
<body>
<div class="wrapper">
  <div id="login-container"></div>
  <div id="modal-container"></div>
  <div class="full top">
	<div class="container">
	  <a href="#menu" id="push-menu" class="btn btn-menu"><i class="fa fa-home"></i></a>
	  <a href="#search" id="push-search" class="btn btn-menu"><i class="fa fa-search"></i></a>
	  <div class="logo"><a href="<?php echo REL_URL.LANG; ?>/" title="<?php echo VCfg::get('site_name'); ?>"><img src="<?php if ($logo_url = VCfg::get('template.defboot.logo_url')): echo $logo_url; else: echo TPL_REL,'/images/logo.png?t='.VCfg::get('template.defboot.logo_time'); endif; ?>" alt="<?php echo VCfg::get('site_name'); ?>"></a></div>
	  <div class="search">
		<?php $icons = array('video' => 'video-camera', 'photo' => 'photo', 'model' => 'female', 'user' => 'users', 'blog' => 'file-text-o', 'game' => 'gamepad', 'forum' => 'list-alt', 'premium' => 'heart');
		$translations = array('video' => __('videos'), 'photo' => __('photos'), 'model' => __('models'), 'user' => __('users'), 'blog' => __('blogs'), 'game' => __('games'), 'forum' => __('forum'), 'premium' => __('premium'));
		if (isset($this->menu) && isset($icons[$this->menu])): $action = $this->menu; $icon = $icons[$this->menu]; else: $action = 'video'; $icon = 'video-camera'; endif; ?>
		<form id="search-form" method="get" action="<?php echo REL_URL,'/search/',$action; ?>/">
		  <div class="input-group">
			<input name="s" type="text" class="form-control" placeholder="<?php echo __('search'); ?>" value="<?php if (isset($this->query) && $this->query): echo e($this->query); endif; ?>">
			<div class="input-group-btn">
              <button type="button" class="btn btn-menu btn-middle dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i id="search-icon" class="fa fa-<?php echo $icon; ?>"></i>
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
			  <ul id="search-menu" class="dropdown-menu dropdown-menu-right" role="menu">
				<?php foreach ($icons as $module => $icon): if (VModule::enabled($module)): ?>
				<li<?php if ($action == $module): echo ' class="active"'; endif; ?>><a href="#search-<?php echo $module; ?>" data-in="<?php echo $module; ?>"><i class="fa fa-<?php echo $icon; ?>"></i> <?php echo $translations[$module]; ?></a></li>
				<?php endif; endforeach; ?>
			  </ul>
			  <button id="search" type="button" class="btn btn-menu btn-search"><i class="fa fa-search"></i></button>			  
			</div>
		  </div>
		</form>
	  </div>
	  <div class="top-links">
		<?php $default = VCfg::get('orientation'); if ($default !== 0): $orientation = orientation(); $orientations = VData::get('orientations', 'core'); $icons = array(1 => 'venus-mars', 2 => 'mars-double', 3 => 'transgender'); ?>
		<div class="dropdown">
		  <button id="orientation" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false" role="button">
			<i class="fa fa-<?php echo $icons[$orientation]; ?>"></i><span class="hidden-xs hidden-sm"> <?php echo __($orientations[$orientation]); ?></span>
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
		  </button>
		  <ul class="dropdown-menu" arealabelledby="orientation">
			<?php foreach ($orientations as $key => $name): $url = ($default == $key) ? '/?orientation='.$name : '/'.$name.'/?orientation='.$name; ?>
			<li<?php if ($orientation == $key): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG.$url; ?>"><i class="fa fa-<?php echo $icons[$key]; ?>"></i> <?php echo __($name); ?></a></li>
			<?php endforeach; ?>
		  </ul>
		</div>
		<?php endif; ?>
		<?php if (VAuth::loggedin()): $requests = p('requests'); ?>
		<div class="dropdown">
		  <button id="dashboard" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false" role="button">
			<i class="fa fa-user"></i> <?php echo __('my-dashboard'); if ($requests): ?> <span class="label label-primary"><?php echo $requests; ?></span><?php endif; ?>
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
		  </button>
		  <ul class="dropdown-menu dropdown-menu-right" arealabelledby="dashboard">
			<?php $submenu = (isset($this->submenu)) ? $this->submenu : false; ?>
            <li<?php if ($submenu == 'user-dashboard'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG; ?>/user/dashboard/"><?php echo __('my-dashboard'); if ($requests): ?> <span class="label label-primary"><?php echo $requests; ?></span><?php endif; ?></a></li>
            <li<?php if ($submenu == 'user-feed'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG; ?>/user/feed/"><?php echo __('my-feed'); ?></a></li>
            <li<?php if ($submenu == 'profile'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG; ?>/users/<?php echo e(VSession::get('username')); ?>/"><?php echo __('my-profile'); ?></a></li>
            <li class="divider"></li>
            <li<?php if ($submenu == 'user-videos'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG; ?>/user/videos/"><?php echo __('my-videos'); ?></a></li>
            <?php if (VModule::enabled('photo')): ?>
            <li<?php if ($submenu == 'user-albums'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG; ?>/user/albums/"><?php echo __('my-albums'); ?></a></li>
            <?php endif; ?>
            <li class="divider"></li>
            <li<?php if ($submenu == 'user-comments'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG; ?>/user/comments/"><?php echo __('my-comments'); ?></a></li>
		  </ul>
		</div>
		<?php $messages = p('messages', VSession::get('user_id')); $icon = ($messages > 0) ? 'envelope-o' : 'envelope-open-o'; ?>
		<a href="<?php echo REL_URL.LANG; ?>/message/inbox/" class="btn btn-xs btn-menu"><i class="fa fa-<?php echo $icon; ?>"></i><span class="hidden-xs hidden-sm"> <?php echo __('inbox'); ?></span><?php if ($messages > 0): ?> <span class="badge"><?php echo $messages; ?></span><?php endif; ?></a>
		<a href="<?php echo REL_URL.LANG; ?>/user/logout/" class="btn btn-xs btn-menu"><i class="fa fa-sign-out"></i> <span class="hidden-xs hidden-sm"><?php echo __('logout'); ?></span></a>		
		<?php else: if (VAuth::loggedin()): ?>
		<a href="<?php echo video_url(); ?>/upload/" class="btn btn-menu btn-xs"><i class="fa fa-upload"></i> <?php echo __('upload'); ?></a>
		<?php endif; ?>
		<a href="<?php echo REL_URL.LANG; ?>/user/signup/" class="btn btn-menu btn-xs"><i class="fa fa-user-plus"></i> <?php echo __('sign-up'); ?></a>
		<a href="<?php echo REL_URL.LANG; ?>/user/login/" class="login btn btn-menu btn-xs"><i class="fa fa-sign-in"></i> <?php echo __('login'); ?></a>
		<?php endif; ?>
		<?php if (VCfg::get('multi_language')): echo p('language'); endif; ?>
	  </div>
	</div>
  </div>
  <div id="menu" class="full navi">
	<div class="container">
	  <ul class="menu"><?php echo p('menu_main', $this->menu); ?></ul>
	  <div class="clearfix"></div>
	</div>
  </div>
  <div class="container content">
	<?php echo p('adv', 'header'); ?>
	<?php echo $this->fetch('_errors'),$this->fetch('_warnings'),$this->fetch('_messages'); ?>
