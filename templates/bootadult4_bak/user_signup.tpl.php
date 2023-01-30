<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_signup.js'; ?>
  <h1 class="mb-4 text-center"><?php echo e($this->title); ?></h1>
  <div class="row justify-content-md-center">
	<div class="col-12 col-md-10 p-4 border rounded">
	  <div class="row">
		<div class="col-12 col-lg-4 order-1 order-lg-2 mb-5">
    	  <ul class="list-group list-group-info">
    		<li class="list-group-item list-group-item-secondary"><h4><?php echo __('not-a-member-yet'); ?></h4></li>
    		<li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-1'); ?></li>
      		<li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-2'); ?></li>
      		<li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-3'); ?></li>
      		<li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-4'); ?></li>
      		<li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-5'); ?></li>
    	  </ul>	
		</div>
		<div class="col-12 col-lg-8 order-2 order-lg-1">
		  <form id="signup-form" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/user/signup/">
			<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
        	<div class="form-group row">
              <label for="username" class="col-sm-3 col-form-label-lg"><?php echo __('username'); ?></label>
              <div class="col-sm-9">
                <input name="username" type="text" class="form-control" id="username" maxlength="<?php echo VCfg::get('user.username_max_length'); ?>" value="<?php echo e($this->signup['username']); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-sm-3 col-form-label-lg"><?php echo __('password'); ?></label>
              <div class="col-sm-9">
                <input name="password" type="password" class="form-control" id="password" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
              </div>
            </div>
            <?php if (VCfg::get('user.signup_password_confirm')): ?>
            <div class="form-group row">
              <label for="password_c" class="col-sm-3 col-form-label-lg"><?php echo __('confirm-password'); ?></label>
              <div class="col-sm-9">
                <input name="password_c" type="password" class="form-control" id="password_c" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
              </div>
            </div>
            <?php endif; ?>
            <div class="form-group row">
              <label for="email" class="col-sm-3 col-form-label-lg"><?php echo __('email'); ?></label>
              <div class="col-sm-9">
                <input name="email" type="text" class="form-control" id="email" maxlength="255" value="<?php echo e($this->signup['email']); ?>">
              </div>
            </div>
            <?php if (VCfg::get('user.signup_name')): ?>
            <div class="form-group row">
              <label for="name" class="col-sm-3 col-form-label-lg"><?php echo __('name'); ?></label>
              <div class="col-sm-9">
                <input name="name" type="text" class="form-control" id="name" maxlength="255" value="<?php echo e($this->signup['name']); ?>">
              </div>
            </div>
            <?php endif; if (VCfg::get('user.signup_gender')): ?>
            <div class="form-group row">
              <label for="gender" class="col-sm-3 col-form-label-lg"><?php echo __('gender'); ?></label>
              <div class="col-sm-9">
            	<?php $genders = $this->genders; unset($genders['0']); foreach ($genders as $id => $gender): ?>
				<div class="custom-control custom-radio custom-control-inline">
				  <input type="radio" id="gender-<?php echo $id; ?>" name="gender" class="custom-control-input" value="<?php echo $id; ?>"<?php if ($this->signup['gender'] == $id): echo ' checked="checked"'; endif; ?>>
				  <label class="custom-control-label" for="gender-<?php echo $id; ?>"><?php echo e($gender); ?></label>
				</div>            	
            	<?php endforeach; ?>
              </div>
            </div>
            <?php endif; if (VCfg::get('user.signup_birth_date')): ?>
            <div class="form-group row">
              <label for="birth_date" class="col-sm-3 col-form-label-lg"><?php echo __('birth-date'); ?></label>
              <div class="col-sm-9">
                <?php echo p('date', $this->signup['birth_date'], 'Date_', true, true, true, ' class="form-control select2"'); ?>
              </div>
            </div>
            <?php endif; if (VCfg::get('user.signup_country')): ?>
            <div class="form-group row">
              <label for="country" class="col-sm-3 col-form-label-lg"><?php echo __('country'); ?></label>
              <div class="col-sm-9">
                <select name="country_id" id="country_id" class="form-control">
                  <option value=""><?php echo __('country-select'); ?></option>
                  <?php foreach (VCountry::getCountries() as $country_id => $country): echo VForm::option($country['countryName'], $country_id, $this->signup['country_id']); endforeach; ?>
                </select>
              </div>
            </div>
            <?php endif; if (VCfg::get('user.signup_city')): ?>
            <div class="form-group row">
              <label for="city" class="col-sm-3 col-form-label-lg"><?php echo __('city'); ?></label>
              <div class="col-sm-9">
                <input name="city" type="text" class="form-control" id="city" maxlength="255" value="<?php echo e($this->signup['city']); ?>">
              </div>
            </div>
            <?php endif; if (VCfg::get('user.signup_zip')): ?>
            <div class="form-group row">
              <label for="zip" class="col-sm-3 col-form-label-lg"><?php echo __('zip'); ?></label>
              <div class="col-sm-9">
                <input name="zip" type="text" class="form-control" id="zip" maxlength="255" value="<?php echo e($this->signup['zip']); ?>">
              </div>
            </div>
            <?php endif; if (VCfg::get('user.signup_captcha')): $captcha = VCfg::get('user.captcha_type'); ?>
            <?php if ($captcha == 'recaptcha'): ?>
            <div class="form-group row">
              <label for="verification" class="col-sm-3 col-form-label-lg"></label>
              <div class="col-sm-9 col-md-4 col-lg-3">
                <div class="g-recaptcha" data-sitekey="<?php echo VCfg::get('recaptcha_site_key'); ?>" id="recaptcha" data-theme="dark"></div>
              </div>
            </div>
            <?php else: $width = ($captcha == 'image') ? 170 : 170; $height = ($captcha == 'image') ? 50 : 50; ?>
            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
                <img src="<?php echo REL_URL,'/captcha.php?driver=',$captcha,'&width=',$width,'&height=',$height,'&r=',rand(1,1000); ?>" alt="Captcha Image" id="captcha-image">
                <a href="#captcha-reload" id="captcha-reload"><i class="fa fa-refresh"></i> <?php echo __('cant-read'); ?></a>
              </div>
            </div>
           <div class="form-group row">
              <label for="code" class="col-sm-3 col-form-label-lg"><?php echo __('verification'); ?></label>
              <div class="col-sm-9 col-md-4 col-lg-3">
                <input name="code" type="text" id="code" class="form-control">
              </div>
            </div>
            <?php endif; endif; if (VCfg::get('user.honeypot')): $honeypot_name = VCfg::get('user.honeypot_name'); ?>
            <div id="<?php echo $honeypot_name; ?>-container" class="form-group">
              <label for="<?php echo $honeypot_name; ?>" class="col-sm-3 col-form-label-lg"><?php echo $honeypot_name; ?></label>
              <div class="col-sm-9 col-md-7 col-lg-6">
                <input name="<?php echo $honeypot_name; ?>" type="text" id="<?php echo $honeypot_name; ?>" class="form-control">
              </div>
            </div>
            <?php endif; ?>
            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
            	<div class="custom-control custom-checkbox">
				  <input name="age_confirm" type="checkbox" class="custom-control-input" id="age_confirm" value="on">
				  <label class="custom-control-label" for="age_confirm"><?php echo __('age-confirm', array('<strong>'.VCfg::get('user.signup_age').'</strong>')); ?></label>
				</div>
            	<div class="custom-control custom-checkbox">
				  <input name="terms_confirm" type="checkbox" class="custom-control-input" id="terms_confirm" value="on">
				  <label class="custom-control-label" for="terms_confirm"><?php echo __('terms-confirm', array('<a href="'.REL_URL.LANG.'/static/terms/" class="btn-color">'.__('terms-and-conditions').'</a>', '<a href="'.REL_URL.LANG.'/static/privacy/" class="btn-color">'.__('privacy-policy').'</a>')); ?></label>
				</div>
              </div>
            </div>            
            <div class="offset-sm-3">
              <button type="submit" name="submit_signup" id="submit-signup" class="btn btn-lg btn-primary"><?php echo __('sign-up'); ?></button>
            </div>
		  </form>
		</div>
	  </div>
	</div>
  </div>
