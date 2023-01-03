<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="profile-c-menu">
  <div class="panel panel-default">
	<img src="<?php echo USER_URL,'/',avatar(false, $this->user_id, $this->user['avatar'], $this->user['gender'], true); ?>" alt="<?php echo __('user-avatar', e($this->username));?>">
	<div class="text-center"><a href="<?php echo REL_URL,LANG,'/users/',e($this->username); ?>/" rel="nofollow"><strong><?php echo e($this->username); ?></strong></a></div>
	<ul class="nav nav-stacked nav-list">
	  <li<?php if ($this->extramenu == 'profile_stream'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/users/',e($this->username); ?>/" rel="nofollow"><?php echo __('profile'); ?></a>
	  <li<?php if ($this->extramenu == 'profile_videos'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/users/',e($this->username); ?>/videos/" rel="nofollow"><?php echo __('videos'); ?></a>
	  <?php if (VModule::enabled('playlist')): ?>
	  <li<?php if ($this->extramenu == 'profile_playlists'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/users/',e($this->username); ?>/playlists/" rel="nofollow"><?php echo __('playlists'); ?></a>
	  <?php endif; if (VModule::enabled('photo')): ?>
	  <li<?php if ($this->extramenu == 'profile_photos'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/users/',e($this->username); ?>/photos/" rel="nofollow"><?php echo __('photos'); ?></a>
	  <?php endif; ?>
	  <li<?php if ($this->extramenu == 'profile_connections'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL,LANG,'/users/',e($this->username); ?>/connections/" rel="nofollow"><?php echo __('connections'); ?></a>
	</ul>
  </div>
</div>
