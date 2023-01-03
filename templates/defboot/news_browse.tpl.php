<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <?php echo $this->fetch('_news_left'); ?>
	  <?php if ($this->articles): foreach ($this->articles as $article): ?>
	  <div class="content-right">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<a href="<?php echo REL_URL.LANG.'/news/'.e($article['slug']); ?>/" class="panel-title btn-color"><strong><?php echo e($article['title']); ?></strong></a><br>
			<small><?php echo __('by'); ?> <a href="<?php echo REL_URL.LANG.'/users/',e($article['username']); ?>/" class="btn-color"><?php echo e($article['username']); ?></a> <?php echo VDate::nice($article['add_time']); ?></small>
		  </div>
		  <div class="panel-body panel-article">
			<?php echo $article['content']; ?>
		  </div>
		</div>
	  </div>
	  <div class="clearfix"></div>
	  <?php endforeach; ?>
	  <nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, REL_URL.LANG.'/news/'.$this->year.$this->month.'#PAGE#/'); ?></ul></nav>
	  <?php else: ?>
	  <div class="none"><?php echo __('no-news'); ?></div>
	  <?php endif; ?>
