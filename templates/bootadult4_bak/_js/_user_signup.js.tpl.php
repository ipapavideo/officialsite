<?php defined('_VALID') or die('Restricted Access!'); ?>
<script src="<?php echo REL_URL; ?>/misc/jquery-pwstrength-bootstrap/pwstrength-bootstrap.min.js"></script>
<?php if (VCfg::get('user.signup_captcha')): $captcha = VCfg::get('user.captcha_type'); if ($captcha == 'recaptcha' and VCfg::get('recaptcha')): ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php endif; endif; ?>
<script type="text/javascript">
$(document).ready(function() {
<?php if (VCfg::get('user.honeypot')): ?>
  $('#<?php echo VCfg::get('user.honeypot_name'); ?>-container').hide();
<?php endif; if (isset($captcha) and $captcha != 'recaptcha'): ?>
  $('#captcha-reload').on('click', function(e) {e.preventDefault(); $('#captcha-image').attr('src', base_url + '<?php echo "/captcha.php?driver=",$captcha,"&r=",rand(1,1000); ?>');});
<?php endif; ?>
});
</script>
<?php VSession::set('time_trap', time()); ?>