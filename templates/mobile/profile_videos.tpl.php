<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php $this->vclass = 'videoss'; if (isset($this->pagination)): ?>
<div class="profile-content-header">
  <div class="profile-title">
	<?php echo $this->title; ?><br>
	<span><?php echo __('showing'),' ',$this->pagination['start_item'],'-',$this->pagination['end_item'],' ',__('of'),' ',$this->pagination['total_items'],' ',__('videos'); ?></span>
  </div>
</div>
<?php if ($this->videos): echo $this->fetch('_video_list'); ?>
<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
<?php else: ?>
<div class="none"><?php echo __('no-videos'); ?></div>
<?php endif; ?>
<?php else: ?>
<?php if (isset($this->total_public_videos) and $this->total_public_videos): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-public-videos-title', $this->username); ?> <span>(<?php echo $this->total_public_videos; ?>)</span></div>
	<?php if ($this->total_public_videos > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/public/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->videos = $this->public_videos; echo $this->fetch('_video_list'); ?>
<?php endif; if (isset($this->total_private_videos) and $this->total_private_videos): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-private-videos-title', $this->username); ?> <span>(<?php echo $this->total_private_videos; ?>)</span></div>
	<?php if ($this->total_private_videos > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/private/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->videos = $this->private_videos; echo $this->fetch('_video_list'); ?>
<?php endif; if (isset($this->total_favorite_videos) and $this->total_favorite_videos): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-favorite-videos-title', $this->username); ?> <span>(<?php echo $this->total_favorite_videos; ?>)</span></div>
	<?php if ($this->total_favorite_videos > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/favorites/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->videos = $this->favorite_videos; echo $this->fetch('_video_list'); ?>
<?php endif; if (isset($this->total_history_videos) and $this->total_history_videos): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-history-videos-title', $this->username); ?> <span>(<?php echo $this->total_history_videos; ?>)</span></div>
	<?php if ($this->total_history_videos > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/history/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->videos = $this->history_videos; echo $this->fetch('_video_list'); ?>
<?php endif; endif; ?>
