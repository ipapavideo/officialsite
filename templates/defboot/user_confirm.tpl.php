<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <div id="content">
		<h1><?php echo e($this->title); ?></h1>
		<span class="help-block"><?php echo __('confirm-help', array(VCfg::get('site_name'))); ?></span>
		<div class="right">
          <h3><?php echo __('signup-reason-title'); ?></h3>
          <ul class="nav nav-stacked">
            <li><i class="fa fa-check-square"></i> <?php echo __('signup-reason-1'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('signup-reason-2'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('signup-reason-3'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('signup-reason-4'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('signup-reason-5'); ?></li>
          </ul>
          <h5 class="text-center"><?php echo __('signup-reason-join', array('<a href="'.BASE_URL.'/user/signup/" class="btn-color"><strong>'.__('signup-now').'</strong></a>', VCfg::get('site_name'))); ?></h4>
		</div>
		<div class="left">
		  <form id="login-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/user/confirm/">
			<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
            <div class="form-group">
              <label for="username" class="col-sm-2 control-label"><i class="fa fa-envelope"></i> <?php echo __('email'); ?></label>
              <div class="col-sm-10 col-md-8 col-lg-7">
                <input name="email" type="text" class="form-control" id="email">
              </div>
            </div>			
            <div class="col-sm-offset-2 col-center">
          	  <button type="submit" name="submit_confirm" id="submit-confirm" class="btn btn-submit"><?php echo __('send'); ?></button>
            </div>
		  </form>
		</div>
		<div class="clearfix"></div>
	  </div>
	  