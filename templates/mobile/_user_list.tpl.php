<?php defined('_VALID') or die('Restricted Access!'); $online_expire = VCfg::get('user.online_expire'); $online = time()-$online_expire; ?>
<ul class="users<?php if (isset($this->uclass)): echo ' ',$this->uclass; endif; ?>">
  <?php $id = (isset($this->id)) ? '-'.$this->id : ''; foreach ($this->users as $user): $username = e($user['username']); ?>
  <li id="user-<?php echo $user['user_id'],$id; ?>" class="user">
    <a href="<?php echo REL_URL,LANG,'/users/',$username; ?>/" title="<?php echo __('user-profile', $username); ?>" rel="nofollow">
  	  <div class="user-thumb">
  		<img src="<?php echo USER_URL,'/',avatar(false, $user['user_id'], $user['avatar'], $user['gender'], false); ?>" alt="<?php echo __('user-avatar', $username); ?>">
  		<?php if ($user['online'] > $online): ?>
  		<span class="user-online"><i class="text-success fa fa-circle-o"></i> <?php echo __('online'); ?></span> 
  		<?php endif; ?>
  	  </div>
    </a>
    <span class="user-title"><a href="<?php echo REL_URL,LANG,'/users/',$username; ?>/" title="<?php echo __('user-profile', $username); ?>" rel="nofollow"><?php echo $username; ?></a></span>
    <?php if (isset($this->requests)): ?>
    <div class="actions">
      <button class="btn-remove btn btn-ns btn-success" data-action="approve" data-id="<?php echo $user['user_id']; ?>"><?php echo __('approve'); ?></button>
      <button class="btn-remove btn btn-ns btn-danger" data-action="deny" data-id="<?php echo $user['user_id']; ?>"><?php echo __('deny'); ?></button>
    </div>    
    <?php endif; if (isset($this->colmenu)): ?>
    <div class="actions">
      <button class="btn-remove btn btn-ns btn-danger" data-id="<?php echo $user['user_id']; ?>" data-sub="<?php echo $this->submenu; ?>"><?php echo __('remove'); ?></button>
    </div>
    <?php endif; ?>
  </li>
  <?php endforeach; ?>
</ul>
<div class="clearfix"></div>
