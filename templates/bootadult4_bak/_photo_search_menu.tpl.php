<?php defined('_VALID') or die('Restricted Access!'); $icons = VData::get('orders_search_icons', 'photo'); if (VCfg::get('photo.browse_timeline')): $timelines = array('viewed', 'rated'); if (in_array($this->order, $timelines)): $timeline_display = true; endif; endif; ?>
<div class="btn-toolbar" role="toolbar">  
  <?php if (isset($timeline_display)): ?>
  <div class="btn-group" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="photo-timeline-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php if ($this->timeline == '' or $this->timeline == 'all'): echo __('all-time'); else: echo __($this->timelines[$this->timeline]); endif; ?>
	  </button>
	  <div class="dropdown-menu" aria-labelledby="photo-timeline-menu">
  		<?php foreach ($this->timelines as $timeline => $name): $active = ($timeline == $this->timeline) ? ' active' : ''; ?>
  		<a href="<?php echo build_search_url($this->query, $this->order, $timeline, 'all', null); ?>" class="dropdown-item<?php echo $active; ?>"></i> <?php echo e($name); ?></a>
  		<?php endforeach; ?>
  		<a href="<?php echo build_search_url($this->query, $this->order, 'all', 'all', null); ?>" class="dropdown-item<?php if ($this->timeline == '' or $this->timeline == 'all'): echo ' active'; endif; ?>"><?php echo __('all-time'); ?></a>
	  </div>
	</div>
  </div>
  <?php endif; ?>
  <div class="btn-group ml-2" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="photo-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  		<i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
	  </button>
	  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="photo-order-menu">
  		<?php foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : '';?>
  		<a href="<?php echo build_search_url($this->query, $order, 'all', 'all', null); ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
  		<?php endforeach; ?>  
	  </div>
	</div>
  </div>
</div>