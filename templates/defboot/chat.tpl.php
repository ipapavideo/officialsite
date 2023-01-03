<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_chat.js'; ?>
<div class="chat-container">
<div class="chat-users">
  <a href="#close-users" id="close-users" class="btn btn-menu"><i class="fa fa-times"></i></a>
  <div class="chat-users-header">
	<img src="<?php echo USER_URL,'/',avatar(true); ?>" alt="<?php echo __('username-avatar', e(VSession::get('username')));?>" width="50" class="img-rounded">
	<strong><?php echo __('my-contact-list'); ?></strong>
  </div>
  <div class="chat-users-list">
	<?php if ($this->users): ?>
	<ul>
	  <?php foreach ($this->users as $user): $username = e($user['username']); ?>
	  <li id="user-<?php echo $user['sender_id']; ?>"<?php if ($user['sender_id'] == $this->user['user_id']): echo ' class="active"'; endif; ?>>
		<a href="<?php echo REL_URL,LANG,'/message/chat/',$username; ?>/"><img src="<?php echo USER_URL,'/',avatar(false, $user['sender_id'], $user['avatar'], $user['gender']);?>" alt="<?php echo __('username-avatar', e($username));?>" width="30" class="img-rounded"></a>
		<a href="<?php echo REL_URL,LANG,'/message/chat/',$username; ?>/" class="btn-link"><strong><?php echo e($username); ?></strong></a>
		<button id="clear" class="btn btn-ns btn-menu pull-right" data-id="<?php echo $user['sender_id']; ?>"><i class="fa fa-times"></i></button>
	  </li>
	  <?php endforeach; ?>
	</ul>
	<?php else: ?>
	<div class="none"><?php echo __('no-users-yet'); ?></div>
	<?php endif; ?>
  </div>
</div>
<div class="chat">
  <div class="chat-header">
	<a href="#push-chat-users" id="push-users" class="btn btn-xs btn-menu"><i class="fa fa-bars"></i></a>
	<div class="chat-avatar">
	  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/"><img src="<?php echo USER_URL,'/',avatar(false, $this->user['user_id'], $this->user['avatar'], $this->user['gender']); ?>" alt="<?php echo __('username-avatar', e($this->username));?>" width="50" class="img-rounded"></a>
	</div>
	<div class="chat-profile">
	  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/" class="btn-link"><strong><?php echo $this->username; ?></strong></a><?php if ($this->user['age'] > 0): echo ', ',$this->user['age']; endif; ?><br>
	  <?php $genders = array(0 => 'genderless', 1 => 'mars-stroke', 2 => 'venus', 3 => 'transgender'); ?><i class="fa fa-<?php echo $genders[$this->user['gender']]; ?>"></i> <?php if ($this->user['country_id']): echo ', ',VCountry::getName($this->user['country_id']); endif; if ($this->user['city']): echo ', ',e($this->user['city']); endif; ?>
	</div>
	<div class="chat-actions">
	  <div id="block">
		<?php if ($this->is_blocked == '1'): ?>
		<button id="block-del" class="btn btn-xs btn-submit btn-block" data-action="del" data-id="<?php echo $this->user['user_id']; ?>"><i class="fa fa-minus"></i> <?php echo __('unblock'); ?></button>
		<?php else: ?>
		<button id="block-add" class="btn btn-xs btn-submit btn-block" data-action="add" data-id="<?php echo $this->user['user_id']; ?>"><i class="fa fa-plus"></i> <?php echo __('block'); ?></button>
		<?php endif; ?>
	  </div>
	  <div id="friend">
		<?php if ($this->is_friend): ?>
		<button id="friend-del" class="btn btn-xs btn-submit btn-friend" data-action="del" data-id="<?php echo $this->user['user_id']; ?>"><i class="fa fa-user-times"></i> <?php echo __('unfriend'); ?></button>
		<?php else: ?>
		<button id="friend-add" class="btn btn-xs btn-submit btn-friend" data-action="add" data-id="<?php echo $this->user['user_id']; ?>"><i class="fa fa-user-plus"></i> <?php echo __('add-friend'); ?></button>
		<?php endif; ?>
	  </div>
	  <button id="delete" class="btn btn-xs btn-submit" data-id="<?php echo $this->user['user_id']; ?>"><?php echo __('clear-history'); ?></button>
	  <div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
  </div>
  <div class="chat-body">
	<?php if ($this->chat): ?>
	<?php if (count($this->chat) > 50): ?>
	<div class="chat-history"><a href="#load-history"><?php echo __('load-previous'); ?></a></div>
	<?php endif; $username = VSession::get('username'); foreach ($this->chat as $index => $message): $class = ($this->user['user_id'] == $message['sender_id']) ? ' sender' : ' receiver'; ?>
	<div id="message-<?php echo $message['msg_id']; ?>" class="message<?php echo $class; ?>" data-id="<?php echo $message['msg_id']; ?>">
	  <div class="message-icon"><i class="fa fa-arrow-<?php if ($class == ' sender'): echo 'down'; else: echo 'up'; endif; ?>"></i></div>
	  <div class="message-username"><span class="username"><?php if ($class == ' sender'): echo $this->username; else: echo $username; endif; ?></span></div>
	  <div class="message-info">
		<?php echo VDate::nice($message['send_time']); ?>
		<button class="btn btn-ns btn-menu btn-delete" data-id="<?php echo $message['msg_id']; ?>"><i class="fa fa-close"></i></button>
	  </div>
	  <div class="clearfix"></div>
	  <div class="message-body">
		<?php echo nl2br(e($message['message'])); ?>
	  </div>
	</div>
	<?php endforeach; ?>
	<?php else: ?>
	<div class="none"><?php echo __('no-messages'); ?></div>
	<?php endif; ?>
  </div>
  <div class="chat-footer">
	<div id="idle" class="alert alert-info text-center" role="alert" style="display: none;"><?php echo __('chat-idle'); ?></div>
	<span class="pull-left"><?php echo __('your-reply'); ?>:</span>
	<span class="pull-right"><i id="spinner" class="fa fa-spinner fa-spin" style="display: none;"></i> <a href="#refresh" id="refresh" data-id="<?php echo $this->user['user_id']; ?>" class="btn-link"><strong><?php echo __('refresh'); ?></strong></a></span>
	<div class="clearfix"></div>
	<div id="response" class="alert alert-danger alert-response" style="display: none;"></div>
	<textarea name="message" id="message" class="form-control" rows="1" data-receiver="<?php echo $this->user['user_id']; ?>"></textarea>
	<div class="chat-post">
	  <button class="btn btn-submit" id="send"><?php echo __('send'); ?></button>
	</div>
  </div>
</div>
</div>