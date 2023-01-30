<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_signup.js'; ?>
  <h1 class="mb-4 text-center"><?php echo e($this->title); ?></h1>
  <div class="row justify-content-md-center">
	<div class="col-12 col-md-10 p-4 border rounded">
	  <div class="row">
		<div class="col-12 col-lg-4 order-1 order-lg-2 mb-5">		
    	  <ul class="list-group">
    		<li class="list-group-item active"><h4><?php echo __('signup-reason-title'); ?></h4></li>
    		<li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-1'); ?></li>
      		<li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-2'); ?></li>
      		<li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-3'); ?></li>
      		<li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-4'); ?></li>
      		<li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-5'); ?></li>
    	  </ul>
    	  <div class="w-100 text-center">
    		<h4 class="mt-2 mb-0 pb-0"><?php echo __('signup-reason-join', array('<a href="'.BASE_URL.'/user/signup/" class="btn-color"><strong>'.__('signup-now').'</strong></a>', VCfg::get('site_name'))); ?></h4>
    	  </div>
		</div>
		<div class="col-12 col-lg-8 order-2 order-lg-1">
		  <form id="signup-form" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/user/lost/">
			<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
            <?php if (isset($this->change) and $this->change): ?>
            <input name="selector" type="hidden" value="<?php echo e($this->selector); ?>">
            <input name="validator" type="hidden" value="<?php echo e($this->validator); ?>">
            <div class="form-group row">
              <label for="password" class="col-sm-2 col-form-label"><?php echo __('password'); ?></label>
              <div class="col-sm-10 col-md-7 col-lg-6">
                <input name="password" type="password" class="form-control" id="password" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="password_c" class="col-sm-2 col-form-label"><?php echo __('confirm-password'); ?></label>
              <div class="col-sm-10 col-md-7 col-lg-6">
                <input name="password_c" type="password" class="form-control" id="password_c" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
              </div>
            </div>
            <div class="col-sm-offset-2">
              <button type="submit" name="submit_change" id="submit-change" class="btn btn-submit"><?php echo __('update-password'); ?></button>
            </div>
            <?php else: ?>
            <div class="form-group row">
              <label for="password" class="col-sm-2 col-form-label"><i class="fa fa-envelope"></i> <?php echo __('email'); ?></label>
              <div class="col-sm-10 col-md-8 col-lg-7">
                <input name="email" type="text" class="form-control" id="email">
              </div>
            </div>
            <div class="offset-sm-2">
              <button type="submit" name="submit_lost" id="submit-lost" class="btn btn-primary btn-lg ml-1"><?php echo __('send'); ?></button>
            </div>
            <?php endif; ?>
		  </form>
		</div>
	  </div>
	</div>
  </div>
