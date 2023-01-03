<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <?php $left = VCfg::get('template.mobile.video_categories_left'); ?>
	  <?php if ($left): ?>
	  <div class="content-left">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title"><?php echo __('categories'); ?></h3>			
		  </div>
		  <div class="panel-body">
			<?php echo p('categories', $this->cat_id); ?>
		  </div>
		</div>
	  </div>
	  <?php endif; ?>
	  <div class="content<?php if ($left): echo '-right'; endif; ?>">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h1 class="panel-title panel-title-left"><?php echo e($this->title); ?></h1>
			<?php if (!isset($this->tag)): echo $this->fetch('_video_menu'); endif; ?>
			<div class="clearfix"></div>
		  </div>
		  <div class="panel-body">
			<?php echo p('adv', 'video-browse-native', false, 'adv-native'); ?>
			<?php if ($this->videos): if ($left): $this->vclass = 'videosl'; endif; echo $this->fetch('_video_list'); else: ?>
			<div class="none"><?php echo __('no-videos'); ?></div>
			<?php endif; ?>
		  </div>
		</div>
		<?php if (isset($this->extramenu) and $this->extramenu == 'related'): ?>
		<nav class="text-center"><ul class="pagination pagination-lg"><?php echo p('pagination', $this->pagination, video_url().'/related/'.$this->video_id.'/#PAGE#/'); ?></ul></nav>
		<?php else: ?>
		<nav class="text-center"><ul class="pagination pagination-lg"><?php echo p('pagination', $this->pagination, build_url($this->order, $this->timeline, $this->slug, true, false, $this->tag)); ?></ul></nav>
		<?php endif; ?>
	  </div>
	  <div class="clearfix"></div>
