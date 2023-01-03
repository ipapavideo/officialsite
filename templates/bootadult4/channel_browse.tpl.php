<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row">
  <div class="col-12">
	<div class="row">
	  <div class="col-12 col-md-7 text-center text-md-left">
		<h1><?php echo e($this->title); ?></h1>
	  </div>
	  <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end pb-1">
		<?php echo $this->fetch('_channel_menu'); ?>
	  </div>
	</div>
	<?php if ($this->channels): echo p('channels', $this->channels); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, build_url($this->orientation, $this->letter, $this->order, true)); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php echo __('no-channels'); ?>
    <?php endif; ?>
  </div>
</div>
