<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_albums.js'; ?>
<div id="response" class="alert alert-dismissible" style="display: none;"></div>
<?php echo $this->fetch('_user_header'); ?>
		<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">  
		<?php if ($this->inbox): echo $this->fetch('_user_inbox'); ?>
		<?php else: ?>
		<div class="none"><?php echo __('no-messages'); ?></div>
		<?php endif; ?>
<?php echo $this->fetch('_user_footer'); ?>
