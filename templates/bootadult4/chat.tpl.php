<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_chat.js'; ?>
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9">
	<div class="chat bg-white border rounded p-1">
	  <div class="d-flex chat-header">
  		<div class="chat-avatar">
    	  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/"><img src="<?php echo USER_URL,'/',avatar(false, $this->user['user_id'], $this->user['avatar'], $this->user['gender']); ?>" alt="<?php echo __('username-avatar', e($this->username));?>" width="30" class="rounded"></a>
  		</div>
  		<div class="chat-profile ml-1">
    	  <a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/" class="btn-link"><strong><?php echo $this->username; ?></strong></a>
    	  <small class="text-muted"><?php if ($this->user['age'] > 0): echo ', ',$this->user['age']; endif; $genders = array(0 => 'genderless', 1 => 'mars-stroke', 2 => 'venus', 3 => 'transgender'); ?> <i class="fa fa-<?php echo $genders[$this->user['gender']]; ?>"></i> <?php if ($this->user['country_id']): echo ', ',VCountry::getName($this->user['country_id']); endif; if ($this->user['city']): echo ', ',e($this->user['city']); endif; ?></small>
  		</div>
  		<div class="ml-auto chat-actions">
  		  <div class="d-flex align-items-center">
    	  <div id="block">
      		<?php if ($this->is_blocked == '1'): ?>
      		<button id="block-del" class="btn btn-xs btn-primary btn-block" data-action="del" data-id="<?php echo $this->user['user_id']; ?>"><i class="fa fa-minus"></i> <?php echo __('unblock'); ?></button>
      		<?php else: ?>
      		<button id="block-add" class="btn btn-xs btn-primary btn-block" data-action="add" data-id="<?php echo $this->user['user_id']; ?>"><i class="fa fa-plus"></i> <?php echo __('block'); ?></button>
      		<?php endif; ?>
    	  </div>
    	  <div id="friend" class="ml-1">
      		<?php if ($this->is_friend): ?>
      		<button id="friend-del" class="btn btn-xs btn-primary btn-friend" data-action="del" data-id="<?php echo $this->user['user_id']; ?>"><i class="fa fa-user-times"></i> <?php echo __('unfriend'); ?></button>
      		<?php else: ?>
      		<button id="friend-add" class="btn btn-xs btn-primary btn-friend" data-action="add" data-id="<?php echo $this->user['user_id']; ?>"><i class="fa fa-user-plus"></i> <?php echo __('add-friend'); ?></button>
      		<?php endif; ?>
    	  </div>
    	  <div id="delete" class="ml-1">
    		<button id="delete" class="btn btn-xs btn-primary" data-id="<?php echo $this->user['user_id']; ?>"><?php echo __('clear-history'); ?></button>
    	  </div>
    	  </div>
    	</div>
  	  </div>
  	  <div class="chat-body">
  		<?php if ($this->chat): if (count($this->chat) > 50): ?>
  		<div class="chat-history"><a href="#load-history"><?php echo __('load-previous'); ?></a></div>
  		<?php endif; $username = VSession::get('username'); foreach ($this->chat as $index => $message): $class = ($this->user['user_id'] == $message['sender_id']) ? ' sender' : ' receiver'; ?>
  		<div id="message-<?php echo $message['msg_id']; ?>" class="media p-1<?php echo $class; ?>" data-id="<?php echo $message['msg_id']; ?>">
  		  <i class="fa fa-arrow-<?php if ($class == ' sender'): echo 'down'; else: echo 'up'; endif; ?>"></i>
  		  <div class="media-body ml-1">
  			<h6><?php if ($class == ' sender'): echo $this->username; else: echo $username; endif; ?> <small class="text-muted"><?php echo VDate::nice($message['send_time']); ?> <button class="btn btn-ns btn-delete" data-id="<?php echo $message['msg_id']; ?>"><i class="fa fa-close text-danger"></i></button></small></h6>
  			<p><?php echo nl2br(e($message['message'])); ?>
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
    <span class="pull-right"><i id="spinner" class="fa fa-spinner fa-spin" style="display: none;"></i> <a href="#refresh" id="refresh" data-id="<?php echo $this->user['user_id']; ?>" class="btn-link"><strong><?p
hp echo __('refresh'); ?></strong></a></span>
    <div class="clearfix"></div>
    <div id="response" class="alert alert-danger alert-response" style="display: none;"></div>
    <textarea name="message" id="message" class="form-control" rows="1" data-receiver="<?php echo $this->user['user_id']; ?>"></textarea>
    <div class="chat-post mt-1">
      <button class="btn btn-sm btn-primary" id="send"><?php echo __('send'); ?></button>
    </div>
  </div>  	  
	</div>
  </div>
  <div class="col-12 col-lg-4 col-xl-3">
	<div class="list-group">
	  <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true"><h5><?php echo __('my-contact-list'); ?></h5></a>
	  <?php if ($this->users): foreach ($this->users as $user): $username = e($user['username']); ?>
	  <a href="<?php echo REL_URL,LANG,'/message/chat/',$username; ?>/" class="list-group-item list-group-item-action"><img src="<?php echo USER_URL,'/',avatar(false, $user['sender_id'], $user['avatar'], $user['gender']);?>" alt="<?php echo __('username-avatar', e($username));?>" width="20" class="rounded"> <strong><?php echo e($username); ?></a>
	  <?php endforeach; else: ?>
	  <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true" style="padding-top: 25px; padding-bottom: 25px;"><?php echo __('no-users-yet'); ?></a>
	  <?php endif; ?>
	</div>
  </div>
</div>
