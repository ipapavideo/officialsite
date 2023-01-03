<?php defined('_VALID') or die('Restricted Access!'); $icons = VData::get('orders_icons', 'model'); if (VCfg::get('model.browse_timeline')): $timelines = array('viewed', 'popular'); if (in_array($this->order, $timelines)): $timeline_display = true; endif; endif; ?>
<div class="btn-toolbar" role="toolbar">
  <div class="btn-group" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="model-letter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php echo __('letter'),': ',ucfirst($this->letter); ?>
	  </button>
	  <div class="dropdown-menu dropdown-menu-inline" aria-labelledby="model-letter">
  		<a href="<?php echo build_url('all', $this->order, $this->timeline, 1, true); ?>" class="dropdown-item dropdown-item-inline<?php if ($this->letter == 'all'): echo ' active'; endif; ?>"><?php echo utf8_strtoupper(__('all')); ?></a>
  		<?php $letters = range('a', 'z'); foreach ($letters as $letter): $active = ($letter == $this->letter) ? ' active'  : '';?>
  		<a href="<?php echo build_url($letter, $this->order, $this->timeline, 1, true); ?>" class="dropdown-item dropdown-item-inline<?php echo $active; ?>"><?php echo strtoupper($letter); ?></a>
  		<?php endforeach; ?>  
	  </div>
	</div>
  </div>
  <div class="btn-group ml-2" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="model-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  		<i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
	  </button>
	  <div class="dropdown-menu" aria-labelledby="model-order-menu">
  		<?php foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : '';?>
  		<a href="<?php echo build_url($this->letter, $order, $this->timeline, 1, true); ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
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
  		<a href="<?php echo build_url($this->letter, $this->order, true, 'timeline' => $timeline); ?>" class="dropdown-item<?php echo $active; ?>"><?php echo __($name); ?></a>
  		<?php endforeach; ?>
  		<a href="<?php echo build_url($this->letter, $this->order, true, 'timeline' => 'all'); ?>" class="dropdown-item<?php if ($this->timeline == '' or $this->timeline == 'all'): echo ' active'; endif; ?>"><?php echo __('all-time'); ?></a>
	  </div>
	</div>
  </div>
  <?php endif; ?>
</div>
