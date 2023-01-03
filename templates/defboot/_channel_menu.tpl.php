<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="btn-toolbar btn-toolbar-menu">
  <?php if (VCfg::get('channel.browse_letter') and $this->order == 'alphabetical'): ?>
  <?php endif; if (VCfg::get('channel.browse_order')): ?>
  <div class="btn-group" role="group">
	<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	  <?php $icons = array(
		'popular'		=> 'line-chart',
		'viewed'		=> 'bar-chart-o',
		'subscribed'	=> 'rss',
		'recent'		=> 'calendar-o',
		'alphabetical'	=> 'sort-alpha-asc',
		'videos'		=> 'video-camera'
	  ); ?>
      <i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>                             
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>	  
	</button>
	<ul class="dropdown-menu dropdown-menu-right">
	  <?php foreach ($this->orders as $order => $name): ?>
	  <li<?php if ($order == $this->order): echo ' class="active"'; endif; ?>><a href="<?php echo build_url($this->orientation, $this->letter, $order); ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a></li>
	  <?php endforeach; ?>
	</ul>
  </div>
  <?php endif; ?>
</div>