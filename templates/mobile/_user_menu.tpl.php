<?php defined('_VALID') or die('Restricted Access!'); ?>
<ul class="nav nav-tabs" role="tablist">
  <li<?php if ($this->submenu == 'user-dashboard'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL,'/user/dashboard/"><i class="fa fa-user"></i> ',__('dashboard'); ?></a></li>
  <li<?php if ($this->submenu == 'user-feed'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL,'/user/feed/"><i class="fa fa-rss"></i> <span class="hidden-xs">',__('feed'); ?></span></a></li>
  <li role="presentation" class="dropdown<?php if (isset($this->colmenu) && $this->colmenu == 'account'): echo ' active'; endif; ?>">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
	  <i class="fa fa-cog"></i> <span class="hidden-xs"><?php echo __('account'); ?></span> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right" role="menu">
  	  <li<?php if ($this->submenu == 'user-account'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/account/">',__('edit-account'); ?></a></li>
      <li<?php if ($this->submenu == 'user-avatar'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/avatar/">',__('edit-picture'); ?></a></li>
      <li<?php if ($this->submenu == 'user-profile'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/profile/">',__('edit-profile'); ?></a></li>
      <li<?php if ($this->submenu == 'user-preferences'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/preferences/">',__('edit-preferences'); ?></a></li>
      <li<?php if ($this->submenu == 'user-notifications'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/notifications/">',__('edit-notifications'); ?></a></li>
    </ul>
  </li>
  <li role="presentation" class="dropdown<?php if (isset($this->colmenu) && $this->colmenu == 'manage'): echo ' active'; endif; ?>">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
  	  <i class="fa fa-bars"></i> <span class="hidden-xs"><?php echo __('manage'); ?></span> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right" role="menu">
  	  <li<?php if ($this->submenu == 'user-videos'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/videos/">',__('my-videos'); ?></a></li>
      <li<?php if ($this->submenu == 'user-history'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/history/">',__('my-view-history'); ?></a></li>
      <li<?php if ($this->submenu == 'user-favorites'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/favorites/">',__('my-favorite-videos'); ?></a></li>
      <li<?php if ($this->submenu == 'user-playlists'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/playlists/">',__('my-playlists'); ?></a></li>
      <?php if (VModule::enabled('photo')): ?>
      <li<?php if ($this->submenu == 'user-albums'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/albums/">',__('my-albums'); ?></a></li>
      <li<?php if ($this->submenu == 'user-photos'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/photos/">',__('my-favorite-photos'); ?></a></li>
      <?php endif; ?>
      <li<?php if ($this->submenu == 'user-friends'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/friends/">',__('my-friends'); ?></a></li>
      <li<?php if ($this->submenu == 'user-subscriptions'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/subscriptions/">',__('my-subscriptions'); ?></a></li>
      <li<?php if ($this->submenu == 'user-subscribers'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/subscribers/">',__('my-subscribers'); ?></a></li>
      <li<?php if ($this->submenu == 'user-comments'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/comments/">',__('my-comments'); ?></a></li>
      <?php if (VModule::enabled('blog')): ?>
      <li<?php if ($this->submenu == 'user-blogs'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/blogs/">',__('my-blogs'); ?></a></li>
      <?php endif; if (VModule::enabled('game')): ?>
      <li<?php if ($this->submenu == 'user-games'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/games/">',__('my-games'); ?></a></li>
      <?php endif; if (VModule::enabled('forum')): ?>
      <li<?php if ($this->submenu == 'user-topics'): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/user/topics/">',__('my-topics'); ?></a></li>
      <?php endif; ?>
      <li<?php if (strpos($this->submenu, 'user-message-') !== false): echo ' class="active"'; endif; ?>><a href="<?= REL_URL,'/message/inbox/">',__('messages'); ?></a></li>
    </ul>
  </li>
</ul>
