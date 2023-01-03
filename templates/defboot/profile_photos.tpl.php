<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php $this->pclass = 'photoss'; $this->aclass = 'albumss'; if (isset($this->pagination)): $items = (isset($this->photos)) ? __('photos') : __('photo-albums'); ?>
<div class="profile-content-header">
  <div class="profile-title">
	<?php echo $this->title; ?><br>
	<span><?php echo __('showing'),' ',$this->pagination['start_item'],'-',$this->pagination['end_item'],' ',__('of'),' ',$this->pagination['total_items'],' ',$items; ?></span>
  </div>
</div>
<?php endif; if (isset($this->albums)): ?>
<?php if ($this->albums): echo $this->fetch('_photo_album_list'); ?>
<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
<?php else: ?>
<div class="none"><?php if (isset($this->none)): echo $this->none; else: echo __('no-albums'); endif; ?></div>
<?php endif; elseif (isset($this->photos)): if ($this->photos): echo $this->fetch('_photo_list'); ?>
<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
<?php else: ?>
<div class="none"><?php if (isset($this->none)): echo $this->none; else: echo __('no-photo'); endif; ?></div>
<?php endif; else: ?>
<?php if (isset($this->total_public_albums) and $this->total_public_albums): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-public-albums-title', $this->username); ?> <span>(<?php echo $this->total_public_albums; ?>)</span></div>
	<?php if ($this->total_public_albums > 5): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/public/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->albums = $this->public_albums; echo $this->fetch('_photo_album_list'); ?>
<?php endif; if (isset($this->total_private_albums) and $this->total_private_albums): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-private-albums-title', $this->username); ?> <span>(<?php echo $this->total_private_albums; ?>)</span></div>
	<?php if ($this->total_private_albums > 5): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/private/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->albums = $this->private_albums; echo $this->fetch('_photo_album_list'); ?>
<?php endif; if (isset($this->total_favorite_photos) and $this->total_favorite_photos): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-favorite-photos-title', $this->username); ?> <span>(<?php echo $this->total_favorite_photos; ?>)</span></div>
	<?php if ($this->total_favorite_photos > 5): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/favorites/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->photos = $this->favorite_photos; echo $this->fetch('_photo_list'); ?>
<?php endif; if (isset($this->total_history_photos) and $this->total_history_photos): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-history-photos-title', $this->username); ?> <span>(<?php echo $this->total_history_photos; ?>)</span></div>
	<?php if ($this->total_history_photos > 5): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/history/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->photos = $this->history_photos; echo $this->fetch('_photo_list'); ?>
<?php endif; endif; ?>
