<?php defined('_VALID') or die('Restricted Access!'); $language = VLanguage::getLanguage(); ?>
<?php if (VCfg::get('comment_captcha') === 2 and VCfg::get('recaptcha')): ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php endif; ?>
<link type="text/css" rel="stylesheet" href="<?php echo REL_URL; ?>/misc/sceditor/minified/themes/default.min.css" />
<script src="<?php echo REL_URL; ?>/misc/sceditor/minified/jquery.sceditor.bbcode.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/sceditor/languages/<?php echo $language; ?>.js"></script>
<script>
$(document).ready(function() {
  $("textarea").sceditor({
	plugins: 'bbcode',
	style: '<?php echo REL_URL; ?>/misc/sceditor/minified/jquery.sceditor.default.min.css',
	toolbar: 'bold,italic,underline|size,color,removeformat|code|image,link|emoticon|maximize,source',
	locale: '<?php echo $language; ?>',
	emoticonsRoot: '<?php echo REL_URL; ?>/misc/sceditor/',
	spellcheck: false,
	parserOptions: {
  	  breakAfterBlock: false,
  	  breakStartBlock: false
	}
  });
});
</script>
