<?php defined('_VALID') or die('Restricted Access!'); ?>
		<div class="panel panel-default panel-search">
		  <div class="panel-heading">
			<h3 class="panel-title pull-left"><?php echo __('duration'); ?></h3>			
			<button type="button" class="btn btn-ns btn-menu btn-panel pull-right" data-target="duration"><i class="fa fa-arrow-up"></i></button>
			<div class="clearfix"></div>
		  </div>
		  <div id="duration" class="panel-body panel-body-search">
			<ul class="nav nav-stacked nav-list">
			  <?php foreach ($this->durations as $duration => $translation): ?>
			  <li<?php if ($this->duration == $duration): echo ' class="active disabled"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, $this->timeline, $duration, $this->cat_id, $this->hd); ?>"><?php echo $translation; ?></a></li>
			  <?php endforeach; ?>
			  <li<?php if ($this->duration == 'all'): echo ' class="active disabled"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, $this->timeline, 'all', $this->cat_id, $this->hd); ?>"><?php echo __('all'); ?></a></li>
			</ul>
		  </div>
		</div>
		<div class="panel panel-default panel-search">
		  <div class="panel-heading">
			<h3 class="panel-title pull-left"><?php echo __('category'); ?></h3>			
			<button type="button" class="btn btn-ns btn-menu btn-panel pull-right" data-target="category"><i class="fa fa-arrow-up"></i></button>
			<div class="clearfix"></div>
		  </div>
		  <div id="category" class="panel-body panel-body-search">
			<?php echo p('categories', $this->cat_id, 'video', $this->categories, $this->query); ?>
		  </div>
		</div>
