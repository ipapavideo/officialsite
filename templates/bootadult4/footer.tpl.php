<?php defined('_VALID') or die('Restricted Access!'); $colors = (isset($_SESSION['theme'])) ? $_SESSION['theme'] : VCfg::get('template.bootadult4.colors'); $cache = VCfg::get('template.bootadult4.cache'); ?>
	<?php echo p('adv_footer'); ?>
  </div>
  <?php if ($text = VCfg::get('template.bootadult4.footer_text') and class_exists('VModule_frontpage', false)): ?>
  <div class="container-fluid">
	<div class="text-center py-4 px-2"><?php echo html_entity_decode($text); ?></div>
  </div>
  <?php endif; ?>
  <div class="footer mt-2 py-3">
	<div class="container-fluid">
	  <div class="row">
		<?php echo p('menu_footer'); ?>
	  </div>
	  <div class="row">
		<div class="col-12 text-center">
		  &copy; <?php echo VCfg::get('site_name'),' ',date('Y'); ?>
		</div>
	  </div>
	</div>
  </div>
  <?php if (VCfg::get('template.bootadult4.gdpr')): echo p('gdpr'); endif; ?>
  <div id="login-container"></div>
  <div id="language-container"></div>
  <div id="playlists-modal-container"></div>
  <div id="playlist-create-container"></div>
<script>var base_url='<?php echo BASE_URL; ?>', cur_url='<?php echo CUR_URL; ?>', ajax_url='<?php echo BASE_URL; ?>', rel_url='<?php echo REL_URL; ?>', tmb_url='<?php echo THUMB_URL; ?>', age_check=<?php echo VCfg::get('age_check'); ?>;</script>
<script src="<?php echo CDN_REL; ?>/misc/jquery3/jquery.min.js"></script>
<script src="<?php echo CDN_REL; ?>/misc/popper/umd/popper.min.js"></script>
<?php if ($minify = VCfg::get('template.bootadult4.minify')): ?>
<?php if (VCfg::get('template.bootadult4.noblock')): ?>
<script>
function addCSS(filename){var h=document.getElementsByTagName('head')[0];var s=document.createElement('link');s.href=filename;s.type='text/css';s.rel='stylesheet';h.append(s);}
$(document).ready(function() {
addCSS('<?php echo REL_URL; ?>/misc/bootstrap4/css/bootstrap-extra.min.css');
addCSS('<?php echo REL_URL; ?>/misc/font-awesome/css/font-awesome.min.css');
<?php if (strpos($colors, 'light') !== false): ?>
addCSS('<?php echo TPL_REL; ?>/css/all-light.min.css?t=<?php echo $cache; ?>');
<?php else: ?>
addCSS('<?php echo TPL_REL; ?>/css/all-dark.min.css?t=<?php echo $cache; ?>');
<?php endif; ?>
});
</script>
<?php endif; ?>
<script src="<?php echo CDN_REL; ?>/misc/bootstrap4/js/bootstrap.min.js"></script>
<script src="<?php echo TPL_REL; ?>/js/all.min.js?t=<?php echo $minify; ?>"></script>
<?php else: ?>
<script src="<?php echo CDN_REL; ?>/misc/overlay-scrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/jquery-touch-swipe/jquery.touchSwipe.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/js-cookie/js.cookie.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/jquery-lazy/jquery.lazy.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/jquery-growl/jquery.growl.js"></script>
<?php if (VCfg::get('template.bootadult4.noblock')): ?>
<script>
function addCSS(filename){var h=document.getElementsByTagName('head')[0];var s=document.createElement('link');s.href=filename;s.type='text/css';s.rel='stylesheet';h.append(s);}
$(document).ready(function() {
addCSS('<?php echo REL_URL; ?>/misc/bootstrap4/css/bootstrap-extra.min.css');
addCSS('<?php echo REL_URL; ?>/misc/font-awesome/css/font-awesome.min.css');
addCSS('<?php echo REL_URL; ?>/misc/overlay-scrollbars/css/OverlayScrollbars.min.css');
addCSS('<?php echo REL_URL; ?>/misc/jquery-growl/jquery.growl.css');
addCSS('<?php echo TPL_REL; ?>/css/theme-<?php echo $colors; ?>.css?t=<?php echo $cache; ?>');
});
</script>
<?php endif; ?>
<script src="<?php echo CDN_REL; ?>/misc/bootstrap4/js/bootstrap.min.js"></script>
<script src="<?php echo TPL_REL; ?>/js/scripts.js?t=<?php echo $cache; ?>"></script>
<?php endif; if (isset($this->_js) && $this->_js): foreach ($this->_js as $tpl): echo $this->fetch('_js/'.$tpl, false); endforeach; endif; echo p('adv_session', 'popup'),p('adv_session', 'popunder'); if ($analytics = VCfg::get('analytics')): echo $analytics; endif; ?>
</body>
</html>
