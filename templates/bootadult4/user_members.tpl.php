<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row">
  <div class="col-12 col-md">
	<div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <div class="h3"><?php echo __('most-popular-members'); ?></div>
      </div>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG; ?>/user/search/?order=popular" class="btn btn-sm btn-light"><i class="fa fa-plus"></i> <?php echo __('see-all'); ?></a>
      </div>
	</div>
	<?php echo p('users', $this->popular, '-popular'); ?>
	<div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <div class="h3"><?php echo __('most-subscribed-members'); ?></div>
      </div>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG; ?>/user/search/?order=subscribed" class="btn btn-sm btn-light"><i class="fa fa-plus"></i> <?php echo __('see-all'); ?></a>
      </div>
	</div>
	<?php echo p('users', $this->subscribed, '-subscribed'); ?>
	<div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <div class="h3"><?php echo __('most-popular-male-members'); ?></div>
      </div>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG; ?>/user/search/?order=popular&gender=male" class="btn btn-sm btn-light"><i class="fa fa-plus"></i> <?php echo __('see-all'); ?></a>
      </div>
	</div>
	<?php echo p('users', $this->popular_male, '-popular-male'); ?>
	<div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <div class="h3"><?php echo __('most-popular-female-members'); ?></div>
      </div>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG; ?>/user/search/?order=popular&gender=female" class="btn btn-sm btn-light"><i class="fa fa-plus"></i> <?php echo __('see-all'); ?></a>
      </div>
	</div>
	<?php echo p('users', $this->popular_female, '-popular-female'); ?>
  </div>
  <div class="col-12 col-md-auto">
	<div class="wm-310">
	  <?php $adv = p('adv', 'community-right'); if ($adv): ?>
	  <div class="d-flex justify-content-center align-items-center"><?php echo $adv; ?></div>
	  <?php endif; ?>
	  <div class="h3 w-100 mt-3 mt-md-2 text-center text-md-left"><?php echo __('online-members'); ?></div>
	  <?php echo p('users_list', $this->online); if (count($this->online) > 5): ?>
	  <div class="w-100 text-center mt-1"><a href="<?php echo REL_URL.LANG; ?>/user/search/?online=yes" class="btn btn-xs btn-primary rounded-pill"><?php echo __('see-all'); ?></a></div>
	  <?php endif; ?>
	  <div class="h3 w-100 mt-3 mt-md-2 text-center text-md-left"><?php echo __('recent-members'); ?></div>
	  <?php echo p('users_list', $this->recent); if (count($this->recent) > 5): ?>
	  <div class="w-100 text-center mt-1"><a href="<?php echo REL_URL.LANG; ?>/user/search/?order=newest" class="btn btn-xs btn-primary rounded-pill"><?php echo __('see-all'); ?></a></div>
	  <?php endif; ?>
	</div>
  </div>
</div>