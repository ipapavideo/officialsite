<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_link_add.js'; ?>
<div class="row">
  <div class="col-8 mx-auto py-2 border rounded">
	<h1><?php echo __('feedback-title'); ?></h1>
	<form id="feedback-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/feedback/">
            <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
            <div class="form-group row">
              <label for="subject" class="col-sm-2 form-col-label"><?php echo __('subject'); ?></label>
              <div class="col-sm-10 col-md-7 col-lg-7">
                <input name="subject" type="text" class="form-control" maxlength="100" value="<?php echo e($this->feedback['subject']); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="message" class="col-sm-2 form-col-label"><?php echo __('message'); ?></label>
              <div class="col-sm-10 col-md-7 col-lg-7">
                <textarea name="message" id="message" class="form-control" rows="10"><?php echo e($this->feedback['message']); ?></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-2 form-col-label"><?php echo __('name'); ?></label>
              <div class="col-sm-10 col-md-5 col-lg-4">
                <input name="name" type="text" class="form-control" maxlength="100" value="<?php echo e($this->feedback['name']); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-2 form-col-label"><?php echo __('email'); ?></label>
              <div class="col-sm-10 col-md-5 col-lg-4">
                <input name="email" type="text" class="form-control" id="email" maxlength="255" value="<?php echo e($this->feedback['email']); ?>">
              </div>
            </div>
            <?php if (VCfg::get('recaptcha')): ?>
            <div class="form-group row">
              <label for="verification" class="col-sm-2 form-col-label"></label>
              <div class="col-sm-10 col-md-4 col-lg-3">
                <div class="g-recaptcha" data-sitekey="<?php echo VCfg::get('recaptcha_site_key'); ?>" id="recaptcha" data-theme="dark"></div>
              </div>
            </div>
            <?php else: ?>
            <div class="form-group row">
              <div class="col-sm-10 offset-sm-2">
                <img src="<?php echo REL_URL,'/captcha.php?driver=image&width=170&height=50&r=',rand(1,1000); ?>" alt="Captcha Image" id="captcha-image">
                <a href="#captcha-reload" id="captcha-reload"><i class="fa fa-refresh"></i> <?php echo __('cant-read'); ?></a>
              </div>
            </div>
            <div class="form-group row">
              <label for="code" class="col-sm-2 form-col-label"><?php echo __('verification'); ?></label>
              <div class="col-sm-10 col-md-3 col-lg-2">
                <input name="code" type="text" id="code" class="form-control">
              </div>
            </div>
            <?php endif; ?>
            <div class="offset-sm-2">
              <button type="submit" name="submit_feedback" id="submit-feedback" class="btn btn-primary btn-lg rounded-pill"><?php echo __('send'); ?></button>
            </div>	
	</form>
  </div>
</div>