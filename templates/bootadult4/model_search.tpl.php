<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_model_search.js'; ?>
<div class="row">
  <div class="col-12">
	<div class="row">
	  <div class="col-12 col-md-7 text-center text-md-left">
		<h1><?php echo e($this->title); ?></h1>
	  </div>
	  <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
		<?php echo $this->fetch('_model_search_menu'); ?>
	  </div>
	</div>
	<?php if (VCfg::get('model.browse_filters')): echo $this->fetch('_model_search_filters'); endif; ?>
	<?php if ($this->models): echo p('models', $this->models); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, build_search_url($this->letter, $this->order)); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php echo __('no-models'); ?>
    <?php endif; ?>
  </div>
</div>
