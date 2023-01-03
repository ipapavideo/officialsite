<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_avatar.js'; ?>
<?php echo $this->fetch('_user_header'); ?>
		<form id="avatar-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/user/avatar/">
		  <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
		  <input name="image_code" id="image_code" type="hidden" value="">
          <div class="form-group">
            <label for="avatar_current" class="col-sm-2 control-label"><?php echo __('current-avatar'); ?></label>
            <div class="col-sm-10">
              <img src="<?php echo USER_URL,'/',avatar(true, $this->user_id, $this->user['avatar'], $this->user['gender'], true); ?>" alt="<?php echo __('current-avatar', $this->user['username']); ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="file" class="col-sm-2 control-label"><?php echo __('file'); ?></label>
            <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
              <div id="upload-container">
                <input name="file" type="file" id="file" accept="image/*">
                <div id="errors" class="help-block text-danger"></div>
              </div>
              <span class="help-block"><?php echo __('avatar-upload-help', array($this->min_width, $this->min_height)); ?></span>
            </div>
          </div>
          <div class="form-group" id="upload-result" style="display: none;">
            <label for="crop" class="col-sm-2 control-label"><?php echo __('crop'); ?></label>
            <div class="col-sm-10" style="height: 350px;">
        	  <div style="width: 300px; height: 300px;" class="img-thumbnail">
        		<div id="crop"></div>
        	  </div>
        	</div>
      	  </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 col-center">
          	  <button type="button" id="submit_crop" class="btn btn-submit" disabled><?php echo __('save'); ?></button>
            </div>
          </div>			  
		</form>
<?php echo $this->fetch('_user_footer'); ?>
