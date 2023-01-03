<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="col-12 comment-post-container border-bottom pb-3 mt-3">
  <input name="csrf_token_comment" type="hidden" value="<?php echo $this->csrf_token; ?>">
  <div id="response-comment" class="alert alert-danger d-none" role="alert"></div>
  <div class="row">
	<div class="col col-auto pr-0">
	  <div style="width: 50px;">
		<img src="<?php echo USER_URL,'/',avatar(true); ?>" alt="<?php echo __('user-avatar'); ?>" class="rounded" width="50">
	  </div>
	</div>
	<div class="col">
	  <?php if (VCfg::get('honeypot')): ?>
	  <input name="comment_field" id="comment-field" type="text" class="form-control form-control-sm d-none" placeholder="Leave this input empty!">
	  <?php endif; ?>
	  <div class="row">
		<?php if (!$this->poster_id): ?>
		<div class="col-12 col-md-4 mb-1">
		<input name="nickname" id="comment-nickname-<?php echo $this->content_id; ?>" type="text" class="form-control form-control-sm" placeholder="<?php echo __('nickname'); ?>">
		</div>
		<?php endif; ?>
		<div class="col-12">
		  <textarea name="comment" id="comment-textarea-<?php echo $this->content_id; ?>" class="form-control form-control-sm elastic" rows="1" placeholder="<?php echo __('comment'); ?>"></textarea>
		</div>
	  </div>
	  <div class="row mt-1">
		<div class="col-12 col-md-6">
		  <?php $captcha = VCfg::get('comment_captcha'); if ($captcha): if ($captcha === 2 and VCfg::get('recaptcha')): ?>
		  <div class="g-recaptcha" data-sitekey="<?php echo VCfg::get('recaptcha_site_key'); ?>" id="recaptcha" data-theme="dark"></div>
		  <?php else: ?>
		  <div class="d-flex justify-content-center justify-content-md-start">
			<img src="<?php echo REL_URL; ?>/captcha/?rand=<?php echo time(); ?>" id="captcha" class="captcha-reload rounded" alt="" data-toggle="tooltip" data-placement="top" title="<?php echo __('click-to-reload-image'); ?>">
			<input name="captcha-verify" type="text" id="comment-captcha-<?php echo $this->content_id; ?>" class="form-control form-control-sm ml-1" style="width: 40px;">
		  </div>
		  <?php endif; endif; ?>
		</div>
		<div class="col-12 col-md-6 mt-2 mt-md-0">
		  <div class="d-flex justify-content-center justify-content-between">
			<small><span id="remaining">500</span> <?php echo __('characters-left'); ?></small>
			<button id="post-comment-<?php echo $this->content_id; ?>" class="btn btn-sm btn-primary" data-id="<?php echo $this->content_id; ?>" data-type="<?php echo $this->ctype; ?>"><?php echo __('post-comment'); ?></button>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
