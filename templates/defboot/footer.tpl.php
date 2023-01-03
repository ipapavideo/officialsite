<?php defined('_VALID') or die('Restricted Access!'); ?>
	<?php echo p('adv_footer'); ?>	
  </div>
  <div class="footer">
	<div class="container">
	  <div class="row">
		<?php echo p('menu_footer'); ?>
	  </div>
	</div>
  </div>
  <div class="copyright">
	<div class="container">
	  <div class="row">
		&copy; <?php echo VCfg::get('site_name'),' ',date('Y'); ?>
	  </div>
	</div>
  </div>
</div>
<script>var base_url='<?php echo BASE_URL; ?>', cur_url='<?php echo CUR_URL; ?>', ajax_url='<?php echo BASE_URL; ?>', rel_url='<?php echo REL_URL; ?>', tmb_url='<?php echo THUMB_URL; ?>', age_check=<?php echo VCfg::get('age_check'); ?>;</script>
<script src="<?php echo CDN_REL; ?>/misc/jquery/jquery.min.js"></script>
<script src="<?php echo CDN_REL; ?>/misc/bootstrap/js/bootstrap.min.js"></script>  
<?php if ($minify = VCfg::get('template.defboot.minify')): ?>
<script src="<?php echo TPL_REL; ?>/js/all.min.js?t=<?php echo $minify; ?>"></script>
<?php else: ?>
<script src="<?php echo CDN_REL; ?>/misc/jquery-slimscroll/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/autosize/autosize.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/jquery-touch-swipe/jquery.touchSwipe.min.js"></script>
<script src="<?php echo TPL_REL; ?>/js/scripts.js"></script>
<?php endif; if (isset($this->_js) && $this->_js): foreach ($this->_js as $tpl): echo $this->fetch('_js/'.$tpl, false); endforeach; endif; ?>
<?php if ($js = VCfg::get('template.defboot.javascript_code_footer')): echo $js; endif; ?>
<?php echo p('adv_session', 'popup'),p('adv_session', 'popunder'); ?>
<?php if ($analytics = VCfg::get('analytics')): echo $analytics; endif; ?>
</body>
</html>
