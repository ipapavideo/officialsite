<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (VCfg::get('recaptcha')): ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php else: ?>
<script>
$(document).ready(function() {
  $('#captcha-reload').on('click', function(e) {e.preventDefault(); $('#captcha-image').attr('src', base_url + '/captcha.php?driver=image&width=170&height=50&r=<?php echo rand(1,1000); ?>');});
});
</script>
<?php endif; ?>