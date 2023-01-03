<?php defined('_VALID') or die('Restricted Access!'); ?>
<div role="tabpanel" class="tab-pane active" id="photos">
  <div class="model-content-menu">
    <div class="model-order-title pull-left"><?php echo e($this->title); ?></div>
    <?php echo $this->fetch('_model_photos_menu'); ?>
	<div class="clearfix"></div>
  </div>
  <?php if ($this->albums): $this->id = '-model'; echo $this->fetch('_photo_album_list'); ?>
  <nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
  <?php else: ?>
  <div class="none"><?php echo __('no-albums'); ?></div>
  <?php endif; ?>
</div>
