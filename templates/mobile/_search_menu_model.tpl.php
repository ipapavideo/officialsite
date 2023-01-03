<?php defined('_VALID') or die('Restricted Access!'); ?>
		<?php if (isset($this->trending) and $this->trending): ?>
		<div class="panel panel-default panel-search">
		  <div class="panel-heading">
			<h3 class="panel-title pull-left"><?php echo __('top-trending-models'); ?></h3>			
			<button type="button" class="btn btn-ns btn-menu btn-panel pull-right" data-target="trending"><i class="fa fa-arrow-up"></i></button>
			<div class="clearfix"></div>
		  </div>
		  <div id="trending" class="panel-body panel-body-search">
			<ul class="image-list">
			  <?php foreach ($this->trending as $model): $arrow = 'up'; $color = 'text-success'; if ($model['rank_prev'] > $model['rank']): $arrow = 'down'; $color = 'text-danger'; endif; ?>
			  <li id="model-<?php echo $model['model_id']; ?>-trending">
				<a href="<?php echo model_url($model['slug']); ?>" title="<?php echo e($model['name']); ?>" class="model-image-l">
				  <img src="<?php echo MODEL_URL,'/',$model['model_id'],'.',$model['ext']; ?>" alt="<?php echo __('model-avatar', e($model['name'])); ?>" class="img-rounded">
				</a>
				<span class="model-name-l"><?php echo e($model['name']); ?></span>
				<span class="model-rank-l"><?php echo __('rank'),': <strong>',$model['rank']; ?></strong> <i class="<?php echo $color,' fa fa-arrow-',$arrow; ?>"></i></span>
				<div class="clearfix"></div>
			  </li>
			  <?php endforeach; ?>
			</ul>
			<div class="clearfix"></div>
		  </div>
		</div>
		<?php endif; ?>