<?php defined('_VALID') or die('Restricted Access!'); ?>
<ul class="models modelss">
  <?php foreach ($this->objects as $object): $model_id = $object['object_id']; $model = unserialize($object['object_data']); ?>  
  <?php $arrow = 'up'; $color = 'text-success'; if ($model['rank_prev'] > $model['rank']): $arrow = 'down'; $color = 'text-danger'; endif; ?>
  <li id="model-<?php echo $model_id; ?>" class="model">
    <a href="<?php echo model_url($model['slug']); ?>" title="<?php echo e($model['name']); ?>" class="image">
      <div class="model-thumb">
        <img src="<?php echo MODEL_URL,'/',$model_id,'.',$model['ext']; ?>" alt="<?php echo __('model-avatar', e($model['name'])); ?>">
        <div class="model-videos"><i class="fa fa-video-camera"></i> <?php echo $model['total_videos']; ?></div>
        <div class="model-rank"><?php echo __('rank'),': <strong>',$model['rank']; ?></strong> <i class="<?php echo $color,' fa fa-arrow-',$arrow; ?>"></i></div>
      </div>
    </a>
    <span class="model-title"><a href="<?php echo model_url($model['slug']); ?>" title="<?php echo e($model['name']); ?>"><?php echo e($model['name']); ?></a></span>
    <span class="views"><?php echo $model['total_views'],' '; if ($model['total_views'] == '1'): echo __('view'); else: echo __('views'); endif; ?></span>
  </li>
  <?php endforeach; ?>
</ul>
