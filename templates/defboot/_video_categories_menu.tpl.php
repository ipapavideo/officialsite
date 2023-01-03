<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="btn-toolbar pull-right">
  <div class="btn-group" role="group">
	<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	  <?php $icons = array(
		'popular'		=> 'line-chart',
		'videos'		=> 'video-camera',
		'alphabetical'  => 'sort-alpha-asc'
	  ); ?>
      <i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>	  
	</button>
	<ul class="dropdown-menu dropdown-menu-right">
	  <?php foreach ($this->orders as $order => $name): ?>
	  <li<?php if ($order == $this->order): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL.LANG.'/categories/?order=',$order; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a></li>
	  <?php endforeach; ?>
	</ul>
  </div>
</div>