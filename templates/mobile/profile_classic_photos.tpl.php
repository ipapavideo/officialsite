<?php defined('_VALID') or die('Restricted Access!'); echo $this->fetch('_profile_classic_menu'); ?>
<div class="profile-c-content">
<?php $this->pclass = 'photoss'; $this->aclass = 'albumss'; if (isset($this->pagination)): $items = (isset($this->photos)) ? __('photos') : __('photo-albums'); ?>
<div class="panel panel-default">
  <div class="panel-heading">
	<div class="panel-title"><?php echo $this->title; ?></div>
  <div>
  <div class="panel-body">
	<?php if ((isset($this->albums) and $this->albums) or (isset($this->photos) and $this->photos)): ?>
	<span class="info"><?php echo __('showing'),' ',$this->pagination['start_item'],'-',$this->pagination['end_item'],' ',__('of'),' ',$this->pagination['total_items'],' ',$items; ?></span>
	<?php if (isset($this->albums)): echo $this->fetch('_photo_album_list'); else: echo $this->fetch('_photo_list'); endif; ?>
	<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
	<?php else: ?>
	<?php if (isset($this->albums)): ?>
	<div class="none"><?php if (isset($this->none)): echo $this->none; else: echo __('no-albums'); endif; ?></div>
	<?php elseif (isset($this->photos)): ?>
	<div class="none"><?php if (isset($this->none)): echo $this->none; else: echo __('no-photo'); endif; ?></div>
	<?php endif; endif; ?>
  </div>
</div>
<?php else: if (isset($this->total_public_albums) and $this->total_public_albums): ?>
<div class="panel panel-default">
  <div class="panel-heading">
	<div class="panel-title panel-title-left"><?php echo __('profile-public-albums-title', $this->username); ?> <span>(<?php echo $this->total_public_albums; ?>)</span></div>
	<?php if ($this->total_public_albums > 5): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/public/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
  </div>
  <div class="panel-body">
	<?php $this->albums = $this->public_albums; echo $this->fetch('_photo_album_list'); ?>
  </div>
</div>
<?php endif; if (isset($this->total_private_albums) and $this->total_private_albums): ?>
<div class="panel panel-default">
  <div class="panel-heading">
	<div class="panel-title panel-title-left"><?php echo __('profile-private-albums-title', $this->username); ?> <span>(<?php echo $this->total_private_albums; ?>)</span></div>
	<?php if ($this->total_private_albums > 5): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/private/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
  </div>
  <div class="panel-body">
	<?php $this->albums = $this->private_albums; echo $this->fetch('_photo_album_list'); ?>
  </div>
</div>
<?php endif; if (isset($this->total_favorite_photos) and $this->total_favorite_photos): ?>
<div class="panel panel-default">
  <div class="panel-heading">
	<div class="panel-title panel-title-left"><?php echo __('profile-favorite-photos-title', $this->username); ?> <span>(<?php echo $this->total_favorite_photos; ?>)</span></div>
	<?php if ($this->total_favorite_photos > 5): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/favorites/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
  </div>
  <div class="panel-body">
	<?php $this->photos = $this->favorite_photos; echo $this->fetch('_photo_list'); ?>
  </div>
</div>
<?php endif; if (isset($this->total_history_photos) and $this->total_history_photos): ?>
<div class="panel panel-default">
  <div class="panel-heading">
	<div class="panel-title panel-title-left"><?php echo __('profile-history-photos-title', $this->username); ?> <span>(<?php echo $this->total_history_photos; ?>)</span></div>
	<?php if ($this->total_history_photos > 5): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/history/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
  </div>
  <div class="panel-body">
	<?php $this->photos = $this->history_photos; echo $this->fetch('_photo_list'); ?>
  </div>
</div>
<?php endif; endif; ?>
</div>
<div class="clearfix"></div>