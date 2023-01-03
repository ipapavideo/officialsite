<?php defined('_VALID') or die('Restricted Access!'); ?>
<div role="tabpanel" class="tab-pane active" id="videos">
  <div class="channel-content-menu">
    <div class="channel-order-title pull-left"><?php echo e($this->title); ?></div>
    <?php echo $this->fetch('_channel_photos_menu'); ?>
	<div class="clearfix"></div>
  </div>
  <?php if ($this->albums): $this->id = '-channel'; echo $this->fetch('_photo_album_list'); ?>
  <nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
  <?php else: ?>
  <div class="none"><?php echo __('no-albums'); ?></div>
  <?php endif; ?>
</div>
