<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <div class="content-left">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title"><?php echo __('categories'); ?></h3>
		  </div>
		  <div class="panel-body">
			<?php echo p('categories', null, 'video', $this->categories); ?>
		  </div>
		</div>
	  </div>
	  <div class="content-right">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h1 class="panel-title pull-left"><?php echo e($this->title); ?></h1>
			<?php echo $this->fetch('_video_categories_menu'); ?>
			<div class="clearfix"></div>
		  </div>
		  <div class="panel-body">
			<?php if ($this->categories): ?>
			<ul class="categories">
			  <?php $ids = array(); foreach ($this->categories as $category): $cat_id = $category['cat_id']; $ids[] = $cat_id; ?>
			  <li id="video-category-<?php echo $cat_id; ?>" class="category">
				<a href="<?php echo video_category_url($category['slug']); ?>" title="<?php echo e($category['name']); ?>" class="image">
				  <div class="category-thumb">
					<img src="<?php echo MEDIA_REL; ?>/videos/cat/<?php echo $category['cat_id'].'.'.$category['ext']; ?>" alt="<?php echo __('category-image', e($category['name'])); ?>">
					<div class="category-videos"><i class="fa fa-video-camera"></i> <?php echo $category['total_videos']; ?></div>
				  </div>
				</a>
				<span class="category-title"><a href="<?php echo video_category_url($category['slug']); ?>" title="<?php echo e($category['name']); ?>"><?php echo e($category['name']); ?></a></span>
			  </li>
			  <?php endforeach; p('ctr_categories', $ids); ?>
			</ul>
			<div class="clearfix"></div>
			<?php else: ?>
			<div class="none"><?php echo __('no-categories'); ?></div>
			<?php endif; ?>
		  </div>
		</div>
	  </div>
	  <div class="clearfix"></div>
