<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_premium_redirect.js'; ?>
      <div id="content">
    	<h1><?php echo __('premium-success-title'); ?></h1>
    	<div class="content">
    	  <div class="none text-center">
    	  <?php if ($this->from == 'register'): echo __('premium-success-register', array(VCfg::get('site_name'), '<a href="'.REL_URL.'/user/login/" class="login"><strong>', '</strong></a>'));
    	  elseif (in_array($this->from, array('renew', 'credit', 'upgrade'))): echo __('premium-success-'.$this->from);
    	  else: echo __('premium-success-help'); endif; ?>
    	  </div>
    	</div>
	  </div>
