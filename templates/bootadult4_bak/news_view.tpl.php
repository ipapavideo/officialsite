<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row">
  <div class="col-12 col-md-3 col-lg-3 col-xl-2 mb-2">
	<?php echo $this->fetch('_news_left'); ?>
  </div>
  <div class="col-12 col-md-9 col-lg-9 col-xl-10">
	<div class="card mb-1">
	  <div class="card-body">
		<h1 class="mb-0 pb-0"><a href="<?php echo REL_URL.LANG.'/news/'.e($this->article['slug']); ?>/"><?php echo e($this->article['title']); ?></a></h1>
		<small class="text-muted"><?php echo __('by'); ?> <a href="<?php echo REL_URL.LANG.'/users/',e($this->article['username']); ?>/" class="btn-color"><?php echo e($this->article['username']); ?></a> <?php echo VDate::nice($this->article['add_time']); ?></small>
		<p class="card-text"><?php echo $this->article['content']; ?></p>
	  </div>
	</div>
  </div>
</div>