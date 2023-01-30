<?php defined('_VALID') or die('Restricted Access!'); $icons = VData::get('orders_search_icons', 'model'); if (VCfg::get('model.browse_timeline')): $timelines = array('viewed', 'popular'); if (in_array($this->order, $timelines)): $timeline_display = true; endif; endif; ?>
<div class="btn-toolbar" role="toolbar">
  <div class="btn-group ml-2" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="model-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  		<i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
	  </button>
	  <div class="dropdown-menu" aria-labelledby="model-order-menu">
  		<?php foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : '';?>
  		<a href="<?php echo build_search_url($this->query, $order, true); ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
  		<?php endforeach; ?>  
	  </div>
	</div>
  </div>
  <?php if (isset($timeline_display)): ?>
  <div class="btn-group ml-2" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="model-timeline-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php if ($this->timeline == '' or $this->timeline == 'all'): echo __('all-time'); else: echo __($this->timelines[$this->timeline]); endif; ?>
	  </button>
	  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="model-timeline-menu">
  		<?php foreach ($this->timelines as $timeline => $name): $active = ($timeline == $this->timeline) ? ' active' : ''; ?>
  		<a href="<?php echo build_search_url($this->query, $this->order, true, 'timeline', $timeline); ?>" class="dropdown-item<?php echo $active; ?>"></i> <?php echo __($name); ?></a>
  		<?php endforeach; ?>
  		<a href="<?php echo build_search_url($this->query, $this->order, true, 'timeline', 'all'); ?>" class="dropdown-item<?php if ($this->timeline == '' or $this->timeline == 'all'): echo ' active'; endif; ?>"><?php echo __('all-time'); ?></a>
	  </div>
	</div>
  </div>
  <?php endif; if (VCfg::get('model.browse_filters')): ?>
  <div class="btn-group ml-2" role="group">
	<button id="model-filters" type="button" class="btn btn-sm btn-light"><?php echo __('more-filters'); ?> <i class="fa fa-plus"></i> </button>
  </div>
  <div class="btn-group ml-2" role="group">
	<a href="<?php echo build_search_url($this->query, $this->order, true); ?>" class="btn btn-sm btn-link text-success" data-toggle="tooltip" data-placement="top" title="<?php echo __('reset-filters'); ?>"><i class="fa fa-toggle-off"></i></a>
  </div>
  <?php endif; ?>
</div>
