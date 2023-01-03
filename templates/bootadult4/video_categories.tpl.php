<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row">
  <div class="col-lg-2 d-none d-lg-block sidebar">
    <?php echo $this->fetch('_video_categories_left_menu'); ?>
  </div>
  <div class="col-lg-10">
	<div class="row">
	  <div class="col-md-8 text-center text-md-left">
		<h1><?php echo e($this->title); ?></h1>
	  </div>
	  <div class="col-md-4 d-flex justify-content-center justify-content-md-end pb-1">
		<?php $icons = VData::get('orders_categories_icons', 'video'); ?>
		<div class="btn-toolbar" role="toolbar">
		  <div class="btn-group ml-2" role="group">
  			<div class="dropdown">
    		  <button class="btn btn-light rounded-pill dropdown-toggle" type="button" id="video-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      			<i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
    		  </button>
    		  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="video-order-menu">
      			<?php foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : '';?>
      			<a href="<?php echo REL_URL.LANG.'/categories/?order=',$order; ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
      			<?php endforeach; ?>
    		  </div>
  			</div>
		  </div>
		</div>
	  </div>
	</div>
	<?php if ($this->categories): echo p('categories', $this->categories); else: ?>
	<div class="none"><?php echo __('no-categories'); ?></div>
	<?php endif; ?>
  </div>
</div>
