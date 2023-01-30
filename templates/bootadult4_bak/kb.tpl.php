<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row">
  <div class="col-12">
	<h1><?php echo e($this->title); ?></h1>
	<?php if ($this->categories): ?>
	<div class="row">
	  <div class="col-12 col-lg-3 col-xl-2">
		<ul class="nav nav-pills flex-lg-column" id="kbTab" role="tablist">
  		  <?php foreach ($this->categories as $index => $category): $active = ($index === 0) ? ' active' : '';?>
  		  <li class="nav-item"><a href="#<?php echo $category['slug']; ?>" class="nav-link<?php echo $active; ?>" id="<?php echo $category['slug']; ?>-tab" data-toggle="tab" role="tab" aria-controls="<?php echo $category['slug']; ?>" aria-selected="<?php if ($active): echo 'true'; else: echo 'false'; endif; ?>"><?php echo e($category['name']); ?></a></li>
  		  <?php endforeach; ?>		  
		</ul>
	  </div>
	  <div class="col-12 col-lg-9 col-xl-10">
		<div class="tab-content mt-2 mt-lg-0 border rounded px-2 py-1" id="kbTabContent">
		  <?php foreach ($this->categories as $index => $category): ?>
		  <div class="tab-pane<?php if ($index === 0): ?> fade show active<?php endif; ?>" id="<?php echo $category['slug']; ?>" role="tabpanel" aria-labelledby="<?php echo $category['slug']; ?>">
			<?php $articles = articles($category['cat_id']); if ($articles): foreach ($articles as $article): ?>
    		<a href="#article-<?php echo $article['article_id']; ?>" class="d-block font-weight-bold" data-toggle="collapse" aria-expanded="false" aria-controls="article-<?php echo $article['article_id']; ?>"><i class="fa fa-angle-right"></i> <?php echo e($article['title']); ?></a>
    		<div class="collapse py-1 px-2" id="article-<?php echo $article['article_id']; ?>">
        	  <?php echo $article['content']; ?>
    		</div>			
			<?php endforeach; else: ?>
			<div class="none"><?php echo __('no-articles'); ?></div>
			<?php endif; ?>
		  </div>
		  <?php endforeach; ?>
		</div>
	  </div>
	</div>
	<?php else: ?>
	<div class="none"><?php echo __('no-categories'); ?></div>
	<?php endif; ?>
  </div>
</div>