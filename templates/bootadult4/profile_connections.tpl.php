<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (isset($this->pagination)): ?>
<div class="row">
  <div class="col-12">
	<h2><?php echo e($this->title); ?></h2>
    <?php if ($this->users): echo p('users', $this->users); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php if (isset($this->none)): echo $this->none; else: echo __('no-users'); endif; ?></div>
    <?php endif; ?>
  </div>
</div>
<?php else: if (isset($this->total_friends) and $this->total_friends): ?>
<div class="row mt-2">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-friends-title', $this->username); ?> <small>(<?php echo $this->total_friends; ?>)</small></h3>
      </div>
      <?php if ($this->total_friends > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/friends/" class="btn btn-sm btn-primary rounded-pill"><?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('users', $this->friends); ?>
  </div>
</div>
<?php endif; if (isset($this->total_subscribers) and $this->total_subscribers): ?>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-subscribers-title', $this->username); ?> <small>(<?php echo $this->total_subscribers; ?>)</small></h3>
      </div>
      <?php if ($this->total_subscribers > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/subscribers/" class="btn btn-sm btn-primary rounded-pill"><?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('users', $this->subscribers); ?>
  </div>
</div>
<?php endif; if (isset($this->total_subscriptions) and $this->total_subscriptions): ?>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-subscriptions-title', $this->username); ?> <small>(<?php echo $this->total_subscriptions; ?>)</small></h3>
      </div>
      <?php if ($this->total_subscriptions > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/subscriptions/" class="btn btn-sm btn-primary rounded-pill"><?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('users', $this->subscriptions); ?>
  </div>
</div>
<?php endif; endif; ?>
