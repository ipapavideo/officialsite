<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_account.js'; ?>
<?php echo $this->fetch('_user_header'); ?>
		<form id="account-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/user/account/">
		  <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
		  <input name="submit_account" type="hidden" value="1">
          <div class="form-group">
            <label for="username" class="col-sm-2 control-label"><?php echo __('username'); ?></label>
            <div class="col-sm-10 col-md-5 col-lg-4">
              <input name="username" type="text" class="form-control" id="username" maxlength="<?php echo VCfg::get('user.username_max_length'); ?>" value="<?php echo e($this->user['username']); ?>"<?php if (!VCfg::get('user.account_username_change')): echo ' readonly'; endif; ?>>
              <?php if (VCfg::get('user.account_username_change')): ?>
              <span class="help-block"><?php echo __('username-change-help'); ?></span>
              <?php endif; ?>
            </div>
          </div>			
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label"><?php echo __('email'); ?></label>
            <div class="col-sm-10 col-md-7 col-lg-7">
              <input name="email" type="text" class="form-control" id="email" maxlength="255" value="<?php echo e($this->user['email']); ?>">
              <?php if (VCfg::get('user.confirm')): ?>
              <span class="help-block"><?php echo __('email-change-help'); ?></span>
              <?php endif; ?>
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-2 control-label"><?php echo __('password'); ?></label>
            <div class="col-sm-10 col-md-6 col-lg-5">
              <input name="password" type="password" class="form-control" id="password" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
            </div>
          </div>			
          <div class="form-group">
            <label for="password_c" class="col-sm-2 control-label"><?php echo __('confirm-password'); ?></label>
            <div class="col-sm-10 col-md-6 col-lg-5">
              <input name="password_c" type="password" class="form-control" id="password_c" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
            </div>
          </div>			
          <?php if (VCfg::get('user.account_pwd_check')): ?>
          <div id="password-container" class="form-group has-warning" style="display: none;">
            <label for="password_o" class="col-sm-2 control-label"><?php echo __('current-password'); ?></label>
            <div class="col-sm-10 col-md-6 col-lg-5">
              <input name="password_o" type="password" class="form-control" id="password_o" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
              <span id="password-error" class="help-block"><?php echo __('current-password-help'); ?></span>
            </div>
          </div>			
          <?php endif; ?>
          <div class="col-sm-offset-2 col-center">
            <button type="button" id="submit-account" class="btn btn-submit"><?php echo __('save'); ?></button>
          </div>
		</form>
<?php echo $this->fetch('_user_footer'); ?>
