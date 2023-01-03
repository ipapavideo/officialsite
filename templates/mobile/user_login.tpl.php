<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <div id="content">
		<h1><?php echo e($this->title); ?></h1>
		<span class="help-block"><?php echo __('login-help', array(VCfg::get('site_name'))); ?></span>
		<div class="right">
		  <h3><?php echo __('signup-reason-title'); ?></h3>
		  <ul class="nav nav-stacked">
        	<li><i class="fa fa-check-square"></i> <?php echo __('signup-reason-1'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('signup-reason-2'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('signup-reason-3'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('signup-reason-4'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('signup-reason-5'); ?></li>
		  </ul>
		  <h5 class="text-center"><?php echo __('signup-reason-join', array('<a href="'.BASE_URL.'/user/signup/" class="btn-color"><strong>'.__('signup-now').'</strong></a>', VCfg::get('site_name'))); ?></h5>
		</div>
		<div class="left">
		  <form id="login-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/user/login/">
			<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
			<?php if (isset($this->redirect) and $this->redirect): ?>
			<input name="r" type="hidden" value="<?php echo e($this->redirect); ?>">
			<?php endif; ?>
            <div class="form-group">
              <label for="username" class="col-sm-2 control-label"><?php echo __('username'); ?></label>
              <div class="col-sm-10 col-md-6 col-lg-5">
                <input name="username" type="text" class="form-control" id="username">
              </div>
            </div>			
            <div class="form-group">
              <label for="password" class="col-sm-2 control-label"><?php echo __('password'); ?></label>
              <div class="col-sm-10 col-md-6 col-lg-5">
                <input name="password" type="password" class="form-control" id="password">
              </div>
            </div>			
            <div class="form-group">
              <div class="col-sm-10 col-sm-offset-2">
            	<div class="checkbox"><input name="remember" type="checkbox" value="1"><label><?php echo __('remember-me-on-this-computer'); ?></label></div>
              </div>
            </div>			
            <div class="form-group">
              <div class="col-sm-10 col-sm-offset-2">
          		<a href="<?php echo REL_URL.LANG; ?>/user/lost/" class="btn-link"><?php echo __('lost-question'); ?></a><br>
          		<a href="<?php echo REL_URL.LANG; ?>/user/confirm/" class="btn-link"><?php echo __('confirm-question'); ?></a>          		
              </div>
            </div>			
            <div class="col-sm-offset-2 col-center">
          	  <button type="submit" name="submit_login" id="submit_login" class="btn btn-submit"><?php echo __('login'); ?></button>
            </div>
		  </form>
		</div>
		<div class="clearfix"></div>
	  </div>
	  