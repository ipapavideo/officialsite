<?php defined('_VALID') or die('Restricted Access!'); ?>
<div role="tabpanel" class="tab-pane active" id="videos">
  <div class="model-content-menu">
    <div class="model-order-title pull-left"><?php echo e($this->title); ?></div>
    <?php echo $this->fetch('_model_videos_menu'); ?>
	<div class="clearfix"></div>
  </div>
  <?php if ($this->videos): $this->vclass = 'related'; $this->id = '-model'; echo $this->fetch('_video_list'); ?>
  <nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
  <?php else: ?>
  <div class="none"><?php echo __('no-videos'); ?></div>
  <?php endif; ?>
</div>
