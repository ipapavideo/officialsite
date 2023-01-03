<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="comment-post-container">
  <div class="post-comment">
	<div id="response-comment" class="alert alert-response content-group" style="display: none;"></div>
	<input name="csrf_token_comment" type="hidden" value="<?php echo $this->csrf_token; ?>">
	<div class="post-comment-image">
	  <img src="<?php echo USER_URL,'/',avatar(true); ?>" alt="<?php echo __('user-avatar'); ?>" class="img-rounded">
	</div>
	<div class="post-comment-message">
	  <?php if (VCfg::get('honeypot')): ?>
	  <input name="comment_field" id="comment-field" type="text" class="form-control" placeholder="Leave this input empty!">
	  <?php endif; if (!$this->poster_id): ?>
	  <input name="nickname" id="comment-nickname-<?php echo $this->content_id; ?>" type="text" class="form-control" placeholder="<?php echo __('nickname'); ?>">
	  <?php endif; ?>
	  <textarea name="comment" id="comment-textarea-<?php echo $this->content_id; ?>" class="form-control elastic" rows="3" placeholder="<?php echo __('comment'); ?>"></textarea>
	  <div class="post-comment-footer">
		<?php $captcha = VCfg::get('comment_captcha'); if ($captcha): if ($captcha === 2 and VCfg::get('recaptcha')): ?>
		<div class="g-recaptcha" data-sitekey="<?php echo VCfg::get('recaptcha_site_key'); ?>" id="recaptcha" data-theme="dark"></div>
		<?php else: ?>
		<div class="captcha-math">
		  <img src="<?php echo REL_URL; ?>/captcha/?rand=<?php echo time(); ?>" id="captcha" class="captcha-reload" alt="" data-toggle="tooltip" data-placement="top" title="<?php echo __('click-to-reload-image'); ?>">
		  <input name="captcha-verify" type="text" id="comment-captcha-<?php echo $this->content_id; ?>" class="form-control">
		</div>
		<?php endif; endif; ?>
		<div class="post-comment-post">
		  <small><span id="remaining">500</span> <?php echo __('characters-left'); ?></small>
		  <button id="post-comment-<?php echo $this->content_id; ?>" class="btn btn-submit btn-post" data-id="<?php echo $this->content_id; ?>" data-type="<?php echo $this->ctype; ?>"><?php echo __('post-comment'); ?></button>
		  <div class="clearfix"></div>
		</div>
	  </div>
	</div>
  </div>
</div>
