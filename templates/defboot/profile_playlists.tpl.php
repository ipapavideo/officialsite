<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php $this->pclass = 'playlistss'; if (isset($this->pagination)): ?>
<div class="profile-content-header">
  <div class="profile-title">
	<?php echo $this->title; ?><br>
	<span><?php echo __('showing'),' ',$this->pagination['start_item'],'-',$this->pagination['end_item'],' ',__('of'),' ',$this->pagination['total_items'],' ',__('playlists'); ?></span>
  </div>
</div>
<?php if ($this->playlists): echo $this->fetch('_playlist_list'); ?>
<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
<?php else: ?>
<div class="none"><?php echo __('no-playlists'); ?></div>
<?php endif; else: ?>
<?php if (isset($this->total_public_playlists) and $this->total_public_playlists): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-public-playlists-title', $this->username); ?> <span>(<?php echo $this->total_public_playlists; ?>)</span></div>
	<?php if ($this->total_public_playlists > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/playlists/public/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->playlists = $this->public_playlists; echo $this->fetch('_playlist_list'); ?>
<?php endif; if (isset($this->total_private_playlists) and $this->total_private_playlists): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-private-playlists-title', $this->username); ?> <span>(<?php echo $this->total_private_playlists; ?>)</span></div>
	<?php if ($this->total_private_playlists > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/playlists/private/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->playlists = $this->private_playlists; echo $this->fetch('_playlist_list'); ?>
<?php endif; if (isset($this->total_favorite_playlists) and $this->total_favorite_playlists): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-favorite-playlists-title', $this->username); ?> <span>(<?php echo $this->total_favorite_playlists; ?>)</span></div>
	<?php if ($this->total_favorite_playlists > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/playlists/favorites/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->playlists = $this->favorite_playlists; echo $this->fetch('_playlist_list'); endif; endif; ?>
