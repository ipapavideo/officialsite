<?php defined('_VALID') or die('Restricted Access!'); ?>
<div id="content">
  <h1><?php echo e($this->title); ?></h1>
  <?php if ($this->categories): ?>
  <ul class="nav nav-tabs" role="tablist">
	<?php foreach ($this->categories as $index => $category): ?>
	<li<?php if ($index === 0): echo ' class="active"'; endif; ?>><a href="#category-<?php echo $category['slug']; ?>" aria-controls="category-<?php echo $category['slug']; ?>" role="tab" data-toggle="tab"><?php echo e($category['name']); ?></a></li>
	<?php endforeach; ?>
  </ul>
  <div class="tab-content">
	<?php foreach ($this->categories as $index => $category): ?>
	<div role="tabpanel" class="tab-pane<?php if ($index === 0): echo ' active'; endif; ?>" id="category-<?php echo $category['slug']; ?>">
	  <?php $articles = articles($category['cat_id']); if ($articles): foreach ($articles as $article): ?>
	  <a href="#article-<?php echo $article['article_id']; ?>" class="kb-title" data-toggle="collapse" aria-expanded="false" aria-controls="article-<?php echo $article['article_id']; ?>"><?php echo e($article['title']); ?></a>
	  <div class="collapse" id="article-<?php echo $article['article_id']; ?>">
		<div class="kb-content">
		  <?php echo $article['content']; ?>
		</div>
	  </div>
	  <?php endforeach; else: ?>
	  <div class="none"><?php echo __('no-articles'); ?></div>
	  <?php endif; ?>
	</div>
	<?php endforeach; ?>
  </div>
  <?php else: ?>
  <div class="none"><?php echo __('no-categories'); ?></div>
  <?php endif; ?>
</div>
