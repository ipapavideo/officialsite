<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_premium_register.js'; ?>
	  <div id="content">
		<h1><?php echo e($this->title); ?></h1>
		<div class="right">
		  <h3><?php echo __('register-reasons-title'); ?></h3>
		  <ul class="nav nav-stacked">
        	<li><i class="fa fa-check-square"></i> <?php echo __('register-reason-1'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('register-reason-2'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('register-reason-3'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('register-reason-4'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('register-reason-5'); ?></li>
		  </ul>
		</div>
		<div class="left">
		  <form id="register-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/premium/register/">
			<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
			<input name="system" type="hidden" value="<?php echo $this->system; ?>">
            <div class="form-group">
              <label for="username" class="col-sm-2 control-label"><?php echo __('username'); ?></label>
              <div class="col-sm-10 col-md-5 col-lg-4">
                <input name="username" type="text" class="form-control" id="username" maxlength="<?php echo VCfg::get('user.username_max_length'); ?>" value="<?php echo e($this->signup['username']); ?>">
              </div>
            </div>			
            <div class="form-group">
              <label for="password" class="col-sm-2 control-label"><?php echo __('password'); ?></label>
              <div class="col-sm-10 col-md-6 col-lg-5">
                <input name="password" type="password" class="form-control" id="password" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
              </div>
            </div>			
            <div class="form-group">
              <label for="email" class="col-sm-2 control-label"><?php echo __('email'); ?></label>
              <div class="col-sm-10 col-md-7 col-lg-7">
                <input name="email" type="text" class="form-control" id="email" maxlength="255" value="<?php echo e($this->signup['email']); ?>">
              </div>
            </div>
            <?php if ($this->methods): ?>
            <div class="form-group">
              <label for="method_id" class="col-sm-2 control-label"><?php echo __('payment-method'); ?></label>
              <div class="col-sm-10">
            	<?php foreach ($this->methods as $method): ?>
            	<div class="radio radio-inline"><input name="method_id" type="radio" id="method_id-<?php echo $method['method_id']; ?>" value="<?php echo $method['method_id']; ?>"<?php if ($method['position'] <= 1): echo ' checked="checked"'; endif; ?>> <label><?php echo __($method['translation']); ?></label></div>
            	<?php endforeach; ?>
              </div>
            </div>            
            <?php endif; ?>            
            <?php if ($this->system == 'subscription'): foreach ($this->methods as $method): $method_id = $method['method_id']; ?>
            <div id="method-<?php echo $method_id; ?>">
          	  <?php foreach ($this->packages as $package): if ($package['method_id'] == $method_id): $package_id = $package['package_id']; ?>
          	  <div class="form-group">
          		<label for="package-<?php echo $package_id; ?>" class="col-sm-2 control-label">&nbsp;</label>
          		<div class="col-sm-10">
          		  <div class="radio"><input name="package_id" type="radio" id="package-<?php echo $package_id; ?>" value="<?php echo $package_id; ?>"<?php if ($package['checked'] == '1'): echo ' checked="checked"'; endif; ?>> <label><?php echo ($package['translation']) ? __($package['translation']) : e($package['name']); ?></label></div>
          		  <span class="help-inline"><?php echo ($package['translation_desc']) ? __($package['translation_desc']) : e($package['description']); ?></span>
          		</div>
          	  </div>
          	  <?php endif; endforeach; ?>
            </div>
            <?php endforeach; else: ?>
            <div class="form-group">
              <label for="credit" class="col-sm-2 control-label"><?php echo __('credit'); ?></label>
              <div class="col-sm-10 col-md-2 col-lg-1">
                <input name="credit" type="text" class="form-control" id="email" maxlength="5" value="<?php echo $this->amount; ?>">
              </div>
              <span class="help-inline"><?php echo $this->currency; ?></span>
            </div>
            <?php endif; if (VCfg::get('premium.signup_captcha')): $captcha = VCfg::get('premium.captcha_type'); ?>
            <?php if ($captcha == 'recaptcha'): ?>
            <div class="form-group">
              <label for="verification" class="col-sm-2 control-label"></label>
              <div class="col-sm-10 col-md-4 col-lg-3">
                <div class="g-recaptcha" data-sitekey="<?php echo VCfg::get('recaptcha_site_key'); ?>" id="recaptcha" data-theme="dark"></div>
              </div>
            </div>
            <?php else: $width = ($captcha == 'image') ? 170 : 170; $height = ($captcha == 'image') ? 50 : 50; ?>
            <div class="form-group">
              <div class="col-sm-10 col-sm-offset-2">
                <img src="<?php echo REL_URL,'/captcha.php?driver=',$captcha,'&width=',$width,'&height=',$height,'&r=',rand(1,1000); ?>" alt="Captcha Image" id="captcha-image">
                <a href="#captcha-reload" id="captcha-reload"><i class="fa fa-refresh"></i> <?php echo __('cant-read'); ?></a>
              </div>
            </div>
            <div class="form-group">
              <label for="code" class="col-sm-2 control-label"><?php echo __('verification'); ?></label>
              <div class="col-sm-10 col-md-3 col-lg-2">
                <input name="code" type="text" id="code" class="form-control">
              </div>
            </div>
            <?php endif; endif; ?>
            <div class="form-group">
          	  <div class="col-sm-10 col-sm-offset-2">
          		<div class="checkbox"><?php echo VForm::checkbox('age_confirm', 'on', $this->signup['age_confirm']); ?> <label><?php echo __('age-confirm', array('<strong>'.VCfg::get('user.signup_age').'</strong>')); ?></label></div>
          		<div class="checkbox"><?php echo VForm::checkbox('terms_confirm', 'on', $this->signup['terms_confirm']); ?> <label><?php echo __('terms-confirm', array('<a href="'.REL_URL.LANG.'/static/terms/" class="btn-color">'.__('terms-and-conditions').'</a>', '<a href="'.REL_URL.LANG.'/static/privacy/" class="btn-color">'.__('privacy-policy').'</a>')); ?></label></div>
          	  </div>
            </div>			
            <div class="col-sm-offset-2 col-center">
          	  <button type="submit" name="submit_register" id="submit-register" class="btn btn-submit"><?php echo __('register'); ?></button>
            </div>
		  </form>
		</div>
		<div class="clearfix"></div>
	  </div>
	  