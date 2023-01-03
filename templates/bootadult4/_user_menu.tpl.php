<?php defined('_VALID') or die('Restricted Access!'); ?>
<ul class="nav nav-pills mb-4">
  <li class="nav-item"><a class="nav-link<?php if ($this->submenu == 'user-dashboard'): echo ' active'; endif; ?>" href="<?php echo REL_URL,'/user/dashboard/"><i class="fa fa-user"></i> ',__('dashboard'); ?></a></li>
  <li class="nav-item"><a class="nav-link<?php if ($this->submenu == 'user-feed'): echo ' active'; endif; ?>" href="<?php echo REL_URL,'/user/feed/"><i class="fa fa-rss"></i> <span class="hidden-xs">',__('feed'); ?></span></a></li>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle<?php if (isset($this->colmenu) && $this->colmenu == 'account'): echo ' active'; endif; ?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-cog"></i> <span class="hidden-xs"><?php echo __('account'); ?></span>
    </a>
    <div class="dropdown-menu" role="menu">
      <a class="dropdown-item<?php if ($this->submenu == 'user-account'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/account/">',__('edit-account'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-avatar'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/avatar/">',__('edit-picture'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-profile'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/profile/">',__('edit-profile'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-preferences'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/preferences/">',__('edit-preferences'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-notifications'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/notifications/">',__('edit-notifications'); ?></a>
    </div>
  </li>
  <li class="nav-item dropdown" role="presentation">
    <a class="nav-link dropdown-toggle<?php if (isset($this->colmenu) && $this->colmenu == 'manage'): echo ' active'; endif; ?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-bars"></i> <span class="hidden-xs"><?php echo __('manage'); ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" role="menu">
      <a class="dropdown-item<?php if ($this->submenu == 'user-videos'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/videos/">',__('my-videos'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-history'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/history/">',__('my-view-history'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-favorites'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/favorites/">',__('my-favorite-videos'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-playlists'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/playlists/">',__('my-playlists'); ?></a>
      <?php if (VModule::enabled('photo')): ?>
      <a class="dropdown-item<?php if ($this->submenu == 'user-albums'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/albums/">',__('my-albums'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-photos'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/photos/">',__('my-favorite-photos'); ?></a>
      <?php endif; ?>
      <a class="dropdown-item<?php if ($this->submenu == 'user-friends'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/friends/">',__('my-friends'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-subscriptions'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/subscriptions/">',__('my-subscriptions'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-subscribers'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/subscribers/">',__('my-subscribers'); ?></a>
      <a class="dropdown-item<?php if ($this->submenu == 'user-comments'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/comments/">',__('my-comments'); ?></a>
      <?php if (VModule::enabled('blog')): ?>
      <a class="dropdown-item<?php if ($this->submenu == 'user-blogs'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/blogs/">',__('my-blogs'); ?></a>
      <?php endif; if (VModule::enabled('game')): ?>
      <a class="dropdown-item<?php if ($this->submenu == 'user-games'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/games/">',__('my-games'); ?></a>
      <?php endif; if (VModule::enabled('forum')): ?>
      <a class="dropdown-item<?php if ($this->submenu == 'user-topics'): echo ' active'; endif; ?>" href="<?= REL_URL,'/user/topics/">',__('my-topics'); ?></a>
      <?php endif; ?>
      <a class="dropdown-item<?php if (strpos($this->submenu, 'user-message-') !== false): echo ' active'; endif; ?>" href="<?= REL_URL,'/message/inbox/">',__('messages'); ?></a>
    </div>
  </li>
</ul>
