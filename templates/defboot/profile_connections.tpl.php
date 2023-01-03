<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php $this->uclass = 'userss'; if (isset($this->pagination)): ?>
<div class="profile-content-header">
  <div class="profile-title">
	<?php echo $this->title; ?><br>
	<span><?php echo __('showing'),' ',$this->pagination['start_item'],'-',$this->pagination['end_item'],' ',__('of'),' ',$this->pagination['total_items'],' ',__('users'); ?></span>
  </div>
</div>
<?php if ($this->users): echo $this->fetch('_user_list'); ?>
<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
<?php else: ?>
<div class="none"><?php if (isset($this->none)): echo $this->none; else: echo __('no-users'); endif; ?></div>
<?php endif; ?>
<?php else: ?>
<?php if (isset($this->total_friends) and $this->total_friends): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-friends-title', $this->username); ?> <span>(<?php echo $this->total_friends; ?>)</span></div>
	<?php if ($this->total_friends > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/friends/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->users = $this->friends; echo $this->fetch('_user_list'); ?>
<?php endif; if (isset($this->total_subscribers) and $this->total_subscribers): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-subscribers-title', $this->username); ?> <span>(<?php echo $this->total_subscribers; ?>)</span></div>
	<?php if ($this->total_subscribers > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/subscribers/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->users = $this->subscribers; echo $this->fetch('_user_list'); ?>
<?php endif; if (isset($this->total_subscriptions) and $this->total_subscriptions): ?>
<div class="profile-content-header">
	<div class="profile-title pull-left"><?php echo __('profile-subscriptions-title', $this->username); ?> <span>(<?php echo $this->total_subscriptions; ?>)</span></div>
	<?php if ($this->total_subscriptions > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/subscriptions/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php $this->users = $this->subscriptions; echo $this->fetch('_user_list'); ?>
<?php endif; endif; ?>
