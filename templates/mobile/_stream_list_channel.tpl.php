<?php defined('_VALID') or die('Restricted Access!'); ?>
<ul class="channels channelss">
  <?php foreach ($this->objects as $object): $channel_id = $object['object_id']; $channel = unserialize($object['object_data']); ?>
  <?php $arrow = 'up'; $color = 'text-success'; if ($channel['rank_prev'] > $channel['rank']): $arrow = 'down'; $color = 'text-danger'; endif; ?>
  <li id="channel-<?php echo $channel['channel_id']; ?>" class="channel">
    <a href="<?php echo REL_URL.LANG.'/channel/',e($channel['slug']); ?>" title="<?php echo e($channel['name']); ?>" class="image">
      <div class="channel-thumb">
        <img src="<?php echo CHANNEL_URL,'/',$channel['channel_id'],'.',$channel['thumb']; ?>" alt="<?php echo __('channel-avatar', e($channel['name'])); ?>">
        <div class="channel-videos"><i class="fa fa-video-camera"></i> <?php echo $channel['total_videos']; ?></div>
        <div class="channel-rank"><?php echo __('rank'),': <strong>',$channel['rank']; ?></strong> <i class="<?php echo $color,' fa fa-arrow-',$arrow; ?>"></i></div>
      </div>
    </a>
    <span class="channel-title"><a href="<?php echo REL_URL.LANG.'/channel/',e($channel['slug']); ?>" title="<?php echo e($channel['name']); ?>"><?php echo e($channel['name']); ?></a></span>
  </li>
  <?php endforeach; ?>
</ul>
