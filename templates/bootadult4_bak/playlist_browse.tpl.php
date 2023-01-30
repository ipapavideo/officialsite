<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row">
  <div class="col-lg-12">
	<div class="row">
	  <div class="col-12 col-md-7 text-center text-md-left">
		<h1><?php echo e($this->title); ?></h1>
	  </div>
	  <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end pb-1">
		<?php echo $this->fetch('_playlist_menu'); ?>
	  </div>
	</div>
	<?php if ($this->playlists): echo p('playlists', $this->playlists); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, build_url($this->orientation, $this->order, $this->timeline, true)); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php echo __('no-playlists'); ?>
    <?php endif; ?>
  </div>
</div>
