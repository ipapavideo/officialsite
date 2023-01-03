<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row">
  <div class="col-12">
	<div class="row">
	  <div class="col-12 col-md-7 text-center text-md-left">
		<h1><?php echo e($this->title); ?></h1>
	  </div>
	  <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end pb-1">
		<?php echo $this->fetch('_model_menu'); ?>
	  </div>
	</div>
	<?php if ($this->models): echo p('models', $this->models); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, build_url($this->letter, $this->order, false, 'page', 1)); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php echo __('no-models'); ?></div>
    <?php endif; ?>
  </div>
</div>
