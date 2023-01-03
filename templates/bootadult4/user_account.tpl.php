<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_account.js'; ?>
<?php echo $this->fetch('_user_header'); ?>
<form id="account-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/user/account/">
<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
<input name="submit_account" type="hidden" value="1">
<div class="row">
  <div class="col-12 col-lg-6">
    <div class="form-group row">
      <label for="username" class="col-sm-3 col-form-label"><?php echo __('username'); ?></label>
      <div class="col-sm-9 col-md-7">
    	<input name="username" type="text" class="form-control" id="username" maxlength="<?php echo VCfg::get('user.username_max_length'); ?>" value="<?php echo e($this->user['username']); ?>"<?php if (!VCfg::get('user.account_username_change')): echo ' readonly'; endif; ?>>
        <?php if (VCfg::get('user.account_username_change')): ?>
        <small class="form-text text-muted"><?php echo __('username-change-help'); ?></small>
        <?php endif; ?>
      </div>
    </div>
    <div class="form-group row">
      <label for="email" class="col-sm-3 control-label"><?php echo __('email'); ?></label>
      <div class="col-sm-9 col-md-7">
    	<input name="email" type="text" class="form-control" id="email" maxlength="255" value="<?php echo e($this->user['email']); ?>">
        <?php if (VCfg::get('user.confirm')): ?>
        <small class="form-text text-muted"><?php echo __('email-change-help'); ?></small>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-6">
    <div class="form-group row">
  	  <label for="password" class="col-sm-3 col-form-label"><?php echo __('password'); ?></label>
      <div class="col-sm-9 col-md-6">
    	<input name="password" type="password" class="form-control" id="password" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="password_c" class="col-sm-3 col-form-label"><?php echo __('confirm-password'); ?></label>
      <div class="col-sm-9 col-md-6">
        <input name="password_c" type="password" class="form-control" id="password_c" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
      </div>
    </div>
    <?php if (VCfg::get('user.account_pwd_check')): ?>
    <div id="password-container" class="form-group row has-warning" style="display: none;">
  	  <label for="password_o" class="col-sm-3 col-form-label"><?php echo __('current-password'); ?></label>
      <div class="col-sm-9 col-md-6">
    	<input name="password_o" type="password" class="form-control" id="password_o" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
        <small id="password-error" class="form-text text-muted"><?php echo __('current-password-help'); ?></small>
      </div>
    </div>
    <?php endif; ?>
  </div>
  <div class="col-12 text-center">
	<button type="button" id="submit-account" class="btn btn-lg btn-primary"><?php echo __('save'); ?></button>
  </div>
</div>
</form>
<?php echo $this->fetch('_user_footer'); ?>
