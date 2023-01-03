<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <?php $left = VCfg::get('template.mobile.photo_categories_left'); ?>
	  <?php if ($left): ?>
	  <div class="content-left">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title"><?php echo __('categories'); ?></h3>			
		  </div>
		  <div class="panel-body">
			<?php echo p('categories', $this->cat_id, 'photo'); ?>
		  </div>
		</div>
	  </div>
	  <?php endif; ?>
	  <div class="content<?php if ($left): echo '-right'; endif; ?>">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h1 class="panel-title panel-title-left"><?php echo e($this->title); ?></h1>
			<?php echo $this->fetch('_photo_menu'); ?>
			<div class="clearfix"></div>
		  </div>
		  <div class="panel-body">
			<?php if ($this->albums): if ($left): $this->aclass = 'albumsl'; endif; echo $this->fetch('_photo_album_list'); else: ?>
			<div class="none"><?php echo __('no-albums'); ?></div>
			<?php endif; ?>
		  </div>
		</div>
		<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, build_url($this->order, $this->timeline, $this->slug, true, false, $this->tag)); ?></ul></nav>
	  </div>
	  <div class="clearfix"></div>
