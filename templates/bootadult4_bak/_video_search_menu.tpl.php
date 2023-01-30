<?php defined('_VALID') or die('Restricted Access!'); $icons = VData::get('orders_search_icons', 'video'); if (VCfg::get('video.browse_timeline')): $timelines = array('viewed', 'rated'); if (in_array($this->order, $timelines)): $timeline_display = true; endif; endif; ?>
<div class="btn-toolbar" role="toolbar" >  
  <div class="btn-group mb-1" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="video-hd-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php if ($this->hd == 'yes' or $this->hd == '1'): echo __('hd'); else: echo __('all'); endif; ?>
	  </button>
	  <div class="dropdown-menu" aria-labelledby="video-hd-menu">
		<a href="<?php echo build_search_url($this->query, $this->order, $this->timeline, $this->duration, $this->cat_id, 'yes', null); ?>" class="dropdown-item<?php if ($this->hd == 'yes' or $this->hd == '1'): echo ' active'; endif; ?>"><?php echo __('hd'); ?></a>
		<a href="<?php echo build_search_url($this->query, $this->order, $this->timeline, $this->duration, $this->cat_id, 'all', null); ?>" class="dropdown-item<?php if ($this->hd == 'all'): echo ' active'; endif; ?>"><?php echo __('all'); ?></a>
	  </div>
	</div>  
  </div>
  <?php if (isset($timeline_display)): ?>
  <div class="btn-group ml-1 mb-1" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="video-timeline-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php if ($this->timeline == '' or $this->timeline == 'all'): echo __('all-time'); else: echo __($this->timelines[$this->timeline]); endif; ?>
	  </button>
	  <div class="dropdown-menu" aria-labelledby="video-timeline-menu">
  		<?php foreach ($this->timelines as $timeline => $name): $active = ($timeline == $this->timeline) ? ' active' : ''; ?>
  		<a href="<?php echo build_search_url($this->query, $this->order, $timeline, 'all', 'all', 'all', null); ?>" class="dropdown-item<?php echo $active; ?>"></i> <?php echo e($name); ?></a>
  		<?php endforeach; ?>
  		<a href="<?php echo build_search_url($this->query, $this->order, 'all', 'all', 'all', 'all', null); ?>" class="dropdown-item<?php if ($this->timeline == '' or $this->timeline == 'all'): echo ' active'; endif; ?>"><?php echo __('all-time'); ?></a>
	  </div>
	</div>
  </div>
  <?php endif; ?>
  <div class="btn-group ml-1 mb-1" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="video-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  		<i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
	  </button>
	  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="video-order-menu">
  		<?php foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : '';?>
  		<a href="<?php echo build_search_url($this->query, $order, 'all', 'all', 'all', 'all', null); ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
  		<?php endforeach; ?>  
	  </div>
	</div>
  </div>
  <div class="btn-group ml-1 mb-1" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="video-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php if ($this->duration == 'all'): echo __('all-durations'); else: echo $this->durations[$this->duration]; endif; ?>
	  </button>
	  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="video-duration-menu">
		<?php foreach ($this->durations as $duration => $translation): $active = ($this->duration == $duration) ? ' active' : ''; ?>
  		<a href="<?php echo build_search_url($this->query, $this->order, $this->timeline, $duration, $this->cat_id, $this->hd); ?>" class="dropdown-item<?php echo $active; ?>"><?php echo e($translation); ?></a>
  		<?php endforeach; ?>  
  		<a href="<?php echo build_search_url($this->query, $this->order, $this->timeline, 'all', $this->cat_id, $this->hd); ?>" class="dropdown-item<?php if ($this->duration == 'all'): echo ' active'; endif; ?>"><?php echo __('all'); ?></a>
	  </div>
	</div>
  </div>
</div>