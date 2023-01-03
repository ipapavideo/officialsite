<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="btn-toolbar btn-toolbar-menu">
  <div class="btn-group" role="group">
	<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	  <?php $icons = array(
		'popular'		=> 'line-chart',
		'subscribed'	=> 'rss-square',
		'newest'		=> 'calendar'
	  ); ?>
      <i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>	  
	</button>
	<ul class="dropdown-menu<?php if (!isset($timeline_display)): echo ' dropdown-menu-right'; endif; ?>">
	  <?php foreach ($this->orders as $order => $name): ?>
	  <li<?php if ($order == $this->order): echo ' class="active"'; endif; ?>><a href="<?php echo build_url('order', $order, true); ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a></li>
	  <?php endforeach; ?>
	</ul>
  </div>
  <div class="btn-group pull-right" role="group">
    <button id="user-filters" type="button" class="btn btn-menu btn-xs"><?php echo __('more-filters'); ?> <i class="fa fa-plus"></i> </button>
  </div>  
</div>