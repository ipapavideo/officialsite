<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="grid mx-auto users">
  <?php foreach ($this->objects as $object): $user_id = $object['object_id']; $user = unserialize($object['object_data']); $username = e($user['username']); ?>
  <div id="user-<?php echo $user_id; ?>" class="cell user">
	<div class="user-thumb">
	  <a href="<?php echo REL_URL,LANG,'/users/',$username; ?>" title="<?php echo __('user-profile', $username); ?>" rel="nofollow">
		<img src="<?php echo USER_URL,'/',avatar(false, $user_id, $user['avatar'], $user['gender']); ?>" alt="<?php echo __('user-avatar', $username); ?>" class="thumb rounded">
	  </a>
	</div>
	<h5 class="w-100 text-center"><a href="<?php echo REL_URL,LANG,'/users/',$username; ?>" title="<?php echo __('user-profile', $username); ?>" rel="nofollow"><?php echo $username; ?></a></h5>
  </div>
  <?php endforeach; ?>
</div>