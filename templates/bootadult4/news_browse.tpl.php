<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row">
  <div class="col-12 col-md-3 col-lg-3 col-xl-2 mb-2">
	<?php echo $this->fetch('_news_left'); ?>
  </div>
  <div class="col-12 col-md-9 col-lg-9 col-xl-10">
	<?php if ($this->articles): foreach ($this->articles as $article): ?>
	<div class="card mb-1">
	  <div class="card-body">
		<h5 class="w-100 border-bottom mb-0 pb-0"><a href="<?php echo REL_URL.LANG.'/news/'.e($article['slug']); ?>/"><?php echo e($article['title']); ?></a></h5>
		<small class="text-muted"><?php echo __('by'); ?> <a href="<?php echo REL_URL.LANG.'/users/',e($article['username']); ?>/" class="btn-color"><?php echo e($article['username']); ?></a> <?php echo VDate::nice($article['add_time']); ?></small>
		<p class="card-text"><?php echo $article['content']; ?></p>
	  </div>
	</div>
	<?php endforeach; ?>
	<nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, REL_URL.LANG.'/news/'.$this->year.$this->month.'#PAGE#/'); ?></ul></nav>
	<?php else: ?>
	<div class="none"><?php echo __('no-news'); ?></div>
	<?php endif; ?>
  </div>
</div>