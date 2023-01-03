<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="grid mx-auto models">
  <?php foreach ($this->objects as $object): $model_id = $object['object_id']; $model = unserialize($object['object_data']);
  $url = model_url($model['slug']); $name       = e($model['name']);
  $arrow = 'up'; $color = ' text-success'; if ($model['rank_prev'] > $model['rank']): $arrow = 'down'; $color = ' text-danger'; endif; ?>
  <div id="model-<?php echo $model_id; ?>" class="cell model">
	<div class="model-thumb">
	  <a href="<?php echo $url; ?>" title="<?php echo $name; ?>"><img src="<?php echo MODEL_URL,'/',$model_id,'.',$model['ext']; ?>" class="thumb" alt="<?php echo __('model-avatar', $name); ?>">
	  <div class="model-info model-videos"><i class="fa fa-video-camera"></i> <?php echo VText::formatNum($model['total_videos']); ?></div>
	  <div class="model-info model-rank">#<?php echo $model['rank']; ?> <i class="fa fa-arrow-<?php echo $arrow,$color; ?>"></i></div>
	  <div class="model-info model-views"><i class="fa fa-eye"></i> <?php echo VText::formatNum($model['total_views']); ?></div>	  
	  </a>
	</div>
	<h5 class="w-100 text-center"><a href="<?php echo $url; ?>" title="<?php echo $name; ?>" rel="nofollow"><?php echo $name; ?></a></h5>
  </div>
  <?php endforeach; ?>
</div>