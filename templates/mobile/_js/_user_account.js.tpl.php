<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $("#submit-account").on('click', function(e) {
	e.preventDefault();
	<?php if (VCfg::get('user.account_pwd_check')): ?>
	$("#password-container").fadeIn();
	if ($("input[name='password_o']").val() != '') {
	  $("#password-error").removeClass('has-warning').addClass('has-success');
  	  $("#account-form").submit();
    }
    <?php else: ?>
  	$("#account-form").submit();
    <?php endif; ?>	
  });
});
</script>
