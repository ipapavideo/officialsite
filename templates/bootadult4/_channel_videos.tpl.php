<?php defined('_VALID') or die('Restricted Access!'); $icons = VData::get('orders_icons', 'video'); ?>
<div class="row mt-2">
  <div class="col-12 col-md-7 text-center text-md-left">
    <div class="h4"><?php echo e($this->title); ?></div>
  </div>
  <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end pb-1">
	<div class="btn-toolbar" role="toolbar">
	  <div class="btn-group ml-2" role="group">
  		<div class="dropdown">
    	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="model-video-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      		<i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
    	  </button>
    	  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="model-video-order-menu">
      		<?php foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : '';?>
      		<a href="<?php echo build_url($this->channel['slug'], $order); ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
      		<?php endforeach; ?>
    	  </div>
  		</div>
	  </div>
	</div>  
  </div>
</div>
<?php if ($this->videos): echo p('videos', $this->videos); ?>
<nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
<?php else: ?>
<div class="none"><?php echo __('no-videos'); ?>
<?php endif; ?>
