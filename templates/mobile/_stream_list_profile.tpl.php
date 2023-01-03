<?php defined('_VALID') or die('Restricted Access!'); ?>
<ul class="users userss">
  <?php foreach ($this->objects as $object): $user_id = $object['object_id']; $user = unserialize($object['object_data']); $username = e($user['username']); ?>  
  <li id="user-<?php echo $user_id; ?>" class="user">
    <a href="<?php echo REL_URL,LANG,'/users/',$username; ?>" title="<?php echo __('user-profile', $username); ?>" rel="nofollow">
      <div class="user-thumb">
        <img src="<?php echo USER_URL,'/',avatar(false, $user_id, $user['avatar'], $user['gender']); ?>" alt="<?php echo __('user-avatar', $username); ?>">
      </div>
    </a>
    <span class="user-title"><a href="<?php echo REL_URL,LANG,'/users/',$username; ?>" title="<?php echo __('user-profile', $username); ?>" rel="nofollow"><?php echo $username; ?></a></span>
  </li>
  <?php endforeach; ?>  
</ul>
