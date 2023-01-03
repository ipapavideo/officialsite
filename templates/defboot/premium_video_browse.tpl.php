<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <?php $left = VCfg::get('template.defboot.video_categories_left'); ?>
	  <?php if ($left): ?>
	  <div class="content-left">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title"><?php echo __('categories'); ?></h3>			
		  </div>
		  <div class="panel-body">
			<?php echo p('categories', $this->cat_id, 'video-premium'); ?>
		  </div>
		</div>
	  </div>
	  <?php endif; ?>
	  <div class="content<?php if ($left): echo '-right'; endif; ?>">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h1 class="panel-title panel-title-left"><?php echo e($this->title); ?></h1>
			<?php echo $this->fetch('_video_menu'); ?>
			<div class="clearfix"></div>
		  </div>
		  <div class="panel-body">
			<?php if ($this->videos): if ($left): $this->vclass = 'videosl'; endif; echo $this->fetch('_video_list'); else: ?>
			<div class="none"><?php echo __('no-videos'); ?></div>
			<?php endif; ?>
		  </div>
		</div>
		<nav class="text-center"><ul class="pagination pagination-lg"><?php echo p('pagination', $this->pagination, build_url($this->order, $this->timeline, $this->slug, true, false, $this->tag)); ?></ul></nav>
	  </div>
	  <div class="clearfix"></div>
