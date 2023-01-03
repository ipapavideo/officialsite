<?php defined('_VALID') or die('Restricted Access!'); $this->wall_rating = VCfg::get('profile.allow_rating'); $this->poster_id = (VAuth::loggedin()) ? (int) VSession::get('user_id') : false; ?>
<div id="wall-report-container"></div>
<?php foreach ($this->stream as $index => $activity): $username = e($activity['username']); $trans = $this->actions[$activity['action_id']]; $count = $activity['cnt']; $is_post = (isset($activity['sub_id']) and $activity['sub_id'] != '0') ? true : false; ?>
<div class="stream">
  <div class="stream-header">
	<?php if ($trans == 'video-channel' or $trans == 'photo-channel'): ?>
	<?php $link = REL_URL.LANG.'/channel/'.e($activity['slug']).'/'; $name = $activity['name']; ?>
	<?php $img = CHANNEL_URL.'/'.$activity['parent_id'].'/'.$activity['ext']; $alt = __('channel-thumb', $name); ?>
	<?php elseif ($trans == 'video-model' or $trans == 'photo-model'): ?>
	<?php $link = model_url($activity['slug']); $name = $activity['name']; ?>
	<?php $img = MODEL_URL.'/'.$activity['parent_id'].'.'.$activity['ext']; $alt = __('model-thumb', $name); ?>
	<?php else: ?>
	<?php $link = REL_URL.LANG.'/users/'.$username.'/'; $name = $username; ?>
	<?php $img = USER_URL.'/'.avatar(false, $activity['user_id'], $activity['avatar'], $activity['gender'], true); $alt = __('username-avatar', $username); ?>
	<?php endif; ?>	
	<div class="stream-avatar">	  
	  <a href="<?php echo $link; ?>" rel="nofollow">
		<img src="<?php echo $img; ?>" alt="<?php echo $alt; ?>" width="50" class="img-rounded">
	  </a>
	</div>
	<div class="stream-info">
	  <a href="<?php echo $link; ?>" rel="nofollow"><?php echo $name; ?></a>
	  <?php if ($is_post): if ($activity['object_data']): $data = unserialize($activity['object_data']); $owner = $data['username']; ?>
	  <?php echo __('activity-profile-post', '<a href="'.REL_URL.'/users/'.$owner.'/" rel="nofollow"><strong>'.$owner.'</strong></a>'); ?>
	  <?php else: echo __('activity-profile-post-self'); endif; else: if ($count == '1'): echo __('activity-'.$trans); ?>
	  <?php else: echo __('activities-'.$trans, $count); endif; endif; ?>
	  <span class="stream-time"><i class="fa fa-clock-o"></i> <?php echo VDate::nice($activity['add_time']); ?></span>
	</div>
	<div class="clearfix"></div>
  </div>
  <?php $class = $trans; if (!$is_post): $class = substr($trans, 0, strpos($trans, '-')); endif; ?>
  <div class="stream-content stream-content-<?php echo $class; ?>">
	<?php if ($is_post): $this->wall_id = $activity['object_id']; echo $this->fetch('_stream_list_post'); else: ?>
	<?php $max = 100; $limits = array('video' => 3, 'photo' => 3, 'album' => 3, 'profile' => 5, 'model' => 5, 'channel' => 4, 'playlist' => 12); if (isset($this->limit)): $max = $limits[$class]; endif; ?>
	<?php if ($count === 1): $this->objects = array($activity); else: $this->objects = $this->amodel->get($activity['ids'], $max); endif; ?>
	<?php echo $this->fetch('_stream_list_'.$class); ?>
	<?php endif; ?>
  </div>
</div>
<?php endforeach; ?>
