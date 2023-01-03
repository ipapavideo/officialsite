<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_inbox.js'; ?>
<div class="inbox">
  <?php foreach ($this->inbox as $message): $username = e($message['username']); ?>
  <div class="inbox-message" id="sender-<?php echo $message['sender_id']; ?>">
	<div class="inbox-image">
	  <a href="<?php echo REL_URL,LANG,'/message/chat/',$username; ?>/">
		<img src="<?php echo USER_URL,'/',avatar(false, $message['sender_id'], $message['avatar'], $message['gender']); ?>" alt="<?php echo __('username-avatar', $username); ?>" class="img-circle img-responsive">
	  </a>	  
	</div>
	<div class="inbox-info">
	  <?php $badge = '<span class="btn-link">'.$username.'</span>'; if ($message['unread'] > 0): $badge = '<span class="btn-link"><strong>'.$username.'</strong></span> <span class="badge">'.$message['unread'].'</span>'; endif; ?>
	  <a href="<?php echo REL_URL,LANG,'/message/chat/',$username; ?>/" target="_blank"><?php echo $badge; ?></a>
	  <span class="inbox-date"><?php echo VDate::nice($message['send_time']); ?></span>
	  <div class="clearfix"></div>
	  <?php $line = $message['message']; if ($pos = utf8_strpos($line, "\r\n")): $line = utf8_substr($line, 0, $pos); endif; ?>
	  <a href="<?php echo REL_URL,LANG,'/message/chat/',$username; ?>/" target="_blank"><small><?php echo $line; ?></small></a>
	</div>
  	<div class="clearfix"></div>
  </div>
  <?php endforeach; ?>
</div>
