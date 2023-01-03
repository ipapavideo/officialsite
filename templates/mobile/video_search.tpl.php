<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_search.js'; ?>
		<?php echo $this->fetch('_search_menu'); ?>
		<?php echo $this->fetch('_search_menu_video'); ?>
	  </div>
	  <div class="content-search-right">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h1 class="panel-title panel-title-left"><?php echo e($this->title); ?></h1>
			<?php echo $this->fetch('_video_search_menu'); ?>
			<div class="clearfix"></div>
		  </div>
		  <div class="panel-body">
			<?php if ($this->videos): $this->vclass = 'videosl'; echo $this->fetch('_video_list'); else: ?>
			<div class="none"><?php echo __('no-videos'); ?></div>
			<?php endif; ?>
		  </div>
		</div>
		<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, build_search_url($this->query, $this->order, $this->timeline, $this->duration, $this->cat_id, $this->hd, $this->page)); ?></ul></nav>
	  </div>
	  <div class="clearfix"></div>
