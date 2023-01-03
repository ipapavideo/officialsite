<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="btn-toolbar btn-toolbar-menu">
  <?php if (VCfg::get('model.browse_order')): ?>
  <div class="btn-group" role="group">
	<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	  <?php $icons = array(
		'recent'        => 'calendar',
		'popular'		=> 'line-chart',
		'viewed'		=> 'bar-chart-o',
		'subscribed'	=> 'rss',
		'favorited'		=> 'heart',
		'alphabetical'	=> 'sort-alpha-asc',
		'videos'		=> 'video-camera'
	  ); ?>
      <i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>                             
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>	  
	</button>
	<ul class="dropdown-menu">
	  <?php foreach ($this->orders as $order => $name): ?>
	  <li<?php if ($order == $this->order): echo ' class="active"'; endif; ?>><a href="<?php echo build_url($this->letter, $order, true); ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a></li>
	  <?php endforeach; ?>
	</ul>
  </div>
  <?php endif; if (VCfg::get('model.browse_timeline')): $timelines = array('viewed'); ?>
  <?php if (in_array($this->order, $timelines)): ?>
  <div class="btn-group" role="group">
	<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
  	  <?php if ($this->timeline == '' or $this->timeline == 'all'): echo __('all-time'); else: echo __($this->timelines[$this->timeline]); endif; ?>
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>
    </button>
	<ul class="dropdown-menu dropdown-menu-right" role="menu">
	  <?php $timelines = $this->timelines; if ($this->order == 'popular'): unset($timelines['today']); endif; foreach ($timelines as $timeline => $name): ?>
	  <li<?php if ($timeline == $this->timeline): echo ' class="active"'; endif; ?>><a href="<?php echo build_url($this->letter, $this->order, $timeline); ?>"></i> <?php echo __($name); ?></a></li>
	  <?php endforeach; ?>
	  <li<?php if ($this->timeline == '' or $this->timeline == 'all'): echo ' class="active"'; endif; ?>><a href=""><?php echo __('all-time'); ?></a></li>
	</ul>
  </div>
  <?php endif; endif; if (VCfg::get('model.browse_filters')): ?>
  <div class="btn-group" role="group">
	<button id="model-filters" type="button" class="btn btn-menu btn-xs"><?php echo __('more-filters'); ?> <i class="fa fa-plus"></i> </button>
  </div>
  <div class="btn-group">
	<a href="<?php echo build_url($this->letter, $this->order, 'all', $this->page, true); ?>" title="<?php echo __('reset-filters'); ?>"><i class="fa fa-toggle-off"></i></a>
  </div>
  <?php endif; ?>
</div>
