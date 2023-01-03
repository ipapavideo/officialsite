<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="grid mx-auto channels">
  <?php foreach ($this->objects as $object): $channel_id = $object['object_id']; $channel = unserialize($object['object_data']);
  $url = REL_URL.LANG.'/channel/'.e($channel['slug']).'/'; $name       = e($channel['name']);
  $arrow = 'up'; $color = ' text-success'; if ($channel['rank_prev'] > $channel['rank']): $arrow = 'down'; $color = ' text-danger'; endif; ?>
  <div id="channel-<?php echo $channel_id; ?>" class="cell channel">
	<div class="channel-thumb">
	  <a href="<?php echo $url; ?>" title="<?php echo $name; ?>"><img src="<?php echo CHANNEL_URL.'/'.$channel_id.'.'.$channel['thumb']; ?>" class="thumb" alt="<?php echo __('channel-avatar', $name); ?>"></a>
	  <div class="channel-info channel-videos"><i class="fa fa-video-camera"></i> <?php echo VText::formatNum($channel['total_videos']); ?></div>
	  <div class="channel-info channel-rank">#<?php echo $channel['rank']; ?> <i class="fa fa-arrow-<?php echo $arrow,$color; ?>"></i></div>
	  <?php if (isset($channel['total_views'])): ?>
	  <div class="channel-info channel-views"><i class="fa fa-eye"></i> <?php echo VText::formatNum($channel['total_views']); ?></div>
	  <?php endif; ?>
	</div>
	<h5 class="w-100 text-center"><a href="<?php echo $url; ?>" title="<?php echo $name; ?>" rel="nofollow"><?php echo $name; ?></a></h5>
  </div>
  <?php endforeach; ?>
</div>