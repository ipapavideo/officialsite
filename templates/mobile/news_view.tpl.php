<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <?php echo $this->fetch('_news_left'); ?>
	  <div class="content-right">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<a href="<?php echo REL_URL.LANG.'/news/'.e($this->article['slug']); ?>/" class="panel-title btn-color"><strong><?php echo e($this->article['title']); ?></strong></a><br>
			<small><?php echo __('by'); ?> <a href="<?php echo REL_URL.LANG.'/users/',e($this->article['username']); ?>/" class="btn-color"><?php echo e($this->article['username']); ?></a> <?php echo VDate::nice($this->article['add_time']); ?></small>
		  </div>
		  <div class="panel-body panel-article">
			<?php echo $this->article['content']; ?>
		  </div>
		</div>
	  </div>
	  <div class="clearfix"></div>
