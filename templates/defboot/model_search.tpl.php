<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_search.js'; ?>
		<?php echo $this->fetch('_search_menu'); ?>
		<?php //echo $this->fetch('_search_menu_model'); ?>
	  </div>
	  <div class="content-search-right">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h1 class="panel-title panel-title-left"><?php echo e($this->title); ?></h1>
			<?php echo $this->fetch('_model_search_menu'); ?>
			<div class="clearfix"></div>
		  </div>
		  <div class="panel-body">
			<?php if (VCfg::get('model.browse_filters')): echo $this->fetch('_model_search_filters'); endif; ?>			
			<?php if ($this->models): echo $this->fetch('_model_list'); else: ?>
			<div class="none"><?php echo __('no-models'); ?></div>
			<?php endif; ?>
		  </div>
		</div>
		<nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
	  </div>
	  <div class="clearfix"></div>
