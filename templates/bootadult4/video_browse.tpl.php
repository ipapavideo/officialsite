<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_browse.js'; ?>
<div class="row">
  <div class="col-lg-3 col-xl-2 d-none d-lg-block sidebar">
    <?php echo $this->fetch('_video_left_menu'); ?>
  </div>
  <div class="col-lg-9 col-xl-10">
	<div class="row">
	  <div class="col-12 col-md-7 text-center text-md-left">
		<h1><?php echo e($this->title); ?></h1>
	  </div>
	  <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end pb-1">
		<?php echo $this->fetch('_video_menu'); ?>
	  </div>
	</div>	
	<?php echo p('adv', 'video-browse-native'); if ($this->videos): echo p('videos', $this->videos); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, build_url($this->order, $this->timeline, $this->slug, true, false, $this->tag)); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php echo __('no-videos'); ?></div>
    <?php endif; ?>
  </div>
</div>
