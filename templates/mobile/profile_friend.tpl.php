<?php defined('_VALID') or die('Restricted Access!'); $login = ($this->is_loggedin) ? '' : 'login '; $this->_js[] = '_profile.js'; ?>
<div id="profile" style="padding: 50px 0; text-align: center; margin-bottom: 10px;" class="none" data-id="<?php echo $this->user_id; ?>" data-username="<?php echo $this->username; ?>">
  <i class="fa fa-user-secret fa-5x"></i><br>
  <?php echo __('profile-private'); ?><br>
  <div id="friend" style="float: none;"><button id="friend-add" class="<?php echo $login; ?>btn btn-submit btn-friend" data-action="add" data-toggle="tooltip" data-placement="top" title="<?php echo __('profile-friend-help'); ?>"><i class="fa fa-user-plus"></i> <?php echo __('add-friend'); ?></button></div>
</div>
