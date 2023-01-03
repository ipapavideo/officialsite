<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_browse.js'; ?>
<div class="row">
  <div class="col-lg-2 d-none d-lg-block sidebar">
	<div class="input-group mb-3">
	  <input type="text" id="categories-filter" class="form-control rounded-left-pill" placeholder="<?php echo __('categories'); ?>" aria-label="">
	  <div class="input-group-append">
  		<button class="btn btn-primary rounded-right-pill btn-search" type="button"><i class="fa fa-search"></i></button>
	  </div>
	</div>
	<div class="list-group list-group-small categories-less">
	  <?php echo p('categories_list', $this->cat_id, 'video', $this->categories, $this->query); ?>
	</div>
  </div>
  <div class="col-lg-10">
	<div class="row">
	  <div class="col-12 col-md-7 text-center text-md-left">
		<h1><?php echo e($this->title); ?></h1>
	  </div>
	  <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end pb-1">
		<?php echo $this->fetch('_video_search_menu'); ?>
	  </div>
	</div>
	<?php if ($this->videos): ?>
    <?php echo p('videos', $this->videos); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, build_search_url($this->query, $this->order, $this->timeline, $this->duration, $this->cat_id, $this->hd, $this->page)); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php echo __('no-videos'); ?></div>
    <?php endif; ?>
  </div>
</div>
