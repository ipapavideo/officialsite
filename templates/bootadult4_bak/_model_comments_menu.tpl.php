<?php defined('_VALID') or die('Restricted Access!'); $icons = array('recent' => 'calendar', 'popular' => 'line-chart'); ?>
<div class="btn-toolbar" role="toolbar">  
  <div class="btn-group ml-2" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="model-video-comments-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  		<i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
	  </button>
	  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="model-comments-order-menu">
  		<?php foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : '';?>
  		<a href="<?php echo build_url($this->model['slug'], $order, 'comments/'); ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
  		<?php endforeach; ?>  
	  </div>
	</div>
  </div>
</div>