<?php defined('_VALID') or die('Restricted Access!'); echo $this->fetch('_profile_classic_menu'); ?>
<div class="profile-c-content">
<?php $this->uclass = 'userss'; if (isset($this->pagination)): ?>
<div class="panel panel-default">
  <div class="panel-heading">
	<div class="panel-title"><?php echo $this->title; ?></div>
  </div>
  <div class="panel-body">
	<?php if ($this->users): ?>
	<span class="info"><?php echo __('showing'),' ',$this->pagination['start_item'],'-',$this->pagination['end_item'],' ',__('of'),' ',$this->pagination['total_items'],' ',__('users'); ?></span>
	<?php echo $this->fetch('_user_list'); ?>
	<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
	<?php else: ?>
	<div class="none"><?php if (isset($this->none)): echo $this->none; else: echo __('no-users'); endif; ?></div>
	<?php endif; ?>
  </div>
</div>
<?php else: ?>
<?php if (isset($this->total_friends) and $this->total_friends): ?>
<div class="panel panel-default">
  <div class="panel-heading">
	<div class="panel-title panel-title-left"><?php echo __('profile-friends-title', $this->username); ?> <span>(<?php echo $this->total_friends; ?>)</span></div>
	<?php if ($this->total_friends > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/friends/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
  </div>
  <div class="panel-body">
	<?php $this->users = $this->friends; echo $this->fetch('_user_list'); ?>
  </div>
</div>
<?php endif; if (isset($this->total_subscribers) and $this->total_subscribers): ?>
<div class="panel panel-default">
  <div class="panel-heading">
	<div class="panel-title panel-title-left"><?php echo __('profile-subscribers-title', $this->username); ?> <span>(<?php echo $this->total_subscribers; ?>)</span></div>
	<?php if ($this->total_subscribers > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/subscribers/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
  </div>
  <div class="panel-body">
	<?php $this->users = $this->subscribers; echo $this->fetch('_user_list'); ?>
  </div>
</div>
<?php endif; if (isset($this->total_subscriptions) and $this->total_subscriptions): ?>
<div class="panel panel-default">
  <div class="panel-heading">
	<div class="panel-title panel-title-left"><?php echo __('profile-subscriptions-title', $this->username); ?> <span>(<?php echo $this->total_subscriptions; ?>)</span></div>
	<?php if ($this->total_subscriptions > 6): ?>
	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/subscriptions/" class="btn btn-xs btn-submit pull-right"><?php echo __('view-all'); ?></a>
	<?php endif; ?>
	<div class="clearfix"></div>
  </div>
  <div class="panel-body">
	<?php $this->users = $this->subscriptions; echo $this->fetch('_user_list'); ?>
  </div>
</div>
<?php endif; endif; ?>
</div>
<div class="clearfix"></div>
