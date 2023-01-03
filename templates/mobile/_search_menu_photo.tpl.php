<?php defined('_VALID') or die('Restricted Access!'); ?>
		<div class="panel panel-default panel-search">
		  <div class="panel-heading">
			<h3 class="panel-title pull-left"><?php echo __('category'); ?></h3>			
			<button type="button" class="btn btn-ns btn-menu btn-panel pull-right" data-target="category"><i class="fa fa-arrow-up"></i></button>
			<div class="clearfix"></div>
		  </div>
		  <div id="category" class="panel-body panel-body-search">			
			<?php echo p('categories', $this->cat_id, 'photo', $this->categories, $this->query); ?>
		  </div>
		</div>
