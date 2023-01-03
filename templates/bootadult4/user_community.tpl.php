<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row">
  <div class="col-12 col-md">
	<div class="h3 w-100"><?php echo $this->title; ?></div>
    <?php if ($this->stream): $this->limit = true; echo $this->fetch('_stream_list'); else: ?>
    <div class="none"><?php echo __('no-activity'); ?></div>
    <?php endif; ?>
  </div>
  <div class="col-12 col-md-auto">
	<div class="wm-310">
	  <?php $adv = p('adv', 'community-right'); if ($adv): ?>
	  <div class="d-flex justify-content-center align-items-center"><?php echo $adv; ?></div>
	  <?php endif; ?>
	  <div class="h3 w-100 mt-3 mt-md-2 text-center text-md-left"><?php echo __('most-popular-users'); ?></div>
	  <?php echo p('users_list', $this->users_popular); ?>
	  <div class="w-100 text-center mt-1"><a href="<?php echo REL_URL.LANG; ?>/user/search/?order=popular" class="btn btn-sm btn-primary rounded-pill"><?php echo __('see-all'); ?></a></div>
	  <div class="h3 w-100 mt-3 mt-md-2 text-center text-md-left"><?php echo __('most-subscribed-users'); ?></div>
	  <?php echo p('users_list', $this->users_subscribed); ?>
	  <div class="w-100 text-center mt-1"><a href="<?php echo REL_URL.LANG; ?>/user/search/?order=subscribed" class="btn btn-sm btn-primary rounded-pill"><?php echo __('see-all'); ?></a></div>
	</div>
  </div>
</div>