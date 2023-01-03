<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="btn-toolbar pull-right">
  <?php if (VCfg::get('playlist.browse_timeline')): $timelines = array('viewed'); ?>
  <?php if (in_array($this->order, $timelines)): $timeline_display = true; endif; endif; if (VCfg::get('playlist.browse_order')): ?>  
  <div class="btn-group" role="group">
	<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	  <?php $icons = array(
		'recent'	=> 'calendar-o',
		'viewed'	=> 'bar-chart-o',
		'rated'		=> 'thumbs-up',
		'favorited'	=> 'heart'
	  ); ?>
      <i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>                             
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>	  
	</button>
	<ul class="dropdown-menu<?php if (!isset($timeline_display)): echo ' dropdown-menu-right'; endif; ?>">
	  <?php foreach ($this->orders as $order => $name): ?>
	  <li<?php if ($order == $this->order): echo ' class="active"'; endif; ?>><a href="<?php echo build_url($this->orientation, $order, 'all'); ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a></li>
	  <?php endforeach; ?>
	</ul>
  </div>
  <?php endif; if (isset($timeline_display)): ?>
  <div class="btn-group pull-right" role="group">
    <button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
      <?php if ($this->timeline == '' or $this->timeline == 'all'): echo __('all-time'); else: echo __($this->timelines[$this->timeline]); endif; ?>
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-right" role="menu">
      <?php $timelines = $this->timelines; if ($this->order == 'popular'): unset($timelines['today']); endif; foreach ($timelines as $timeline => $name): ?>
      <li<?php if ($timeline == $this->timeline): echo ' class="active"'; endif; ?>><a href="<?php echo build_url($this->orientation, $this->order, $timeline); ?>"> <?php echo __($name); ?></a></li>
      <?php endforeach; ?>
      <li<?php if ($this->timeline == '' or $this->timeline == 'all'): echo ' class="active"'; endif; ?>><a href="<?php echo build_url($this->orientation, $this->order, 'all'); ?>"><?php echo __('all-time'); ?></a></li>
    </ul>
  </div>  
  <?php endif; ?>
</div>