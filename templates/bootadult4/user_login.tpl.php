<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row mb-3">
  <div class="col-8 mx-auto">
	<h1 class="mb-4 text-center"><?php echo e($this->title); ?></h1>
	<div class="row justify-content-md-center">
	  <div class="col-12 col-md-5 order-1 order-md-2">
    	<ul class="list-group mb-2">
    	  <li class="list-group-item list-group-item-secondary"><h5><?php echo __('not-a-member-yet'); ?></h5></li>
    	  <li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-1'); ?></li>
      	  <li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-2'); ?></li>
      	  <li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-3'); ?></li>
      	  <li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-4'); ?></li>
      	  <li class="list-group-item"><i class="fa fa-check-square"></i> <?php echo __('signup-reason-5'); ?></li>
    	</ul>
        <div class="w-100 text-center mb-4">
          <h6 class="mt-2 mb-0 pb-0"><?php echo __('signup-reason-join', array('<a href="'.BASE_URL.'/user/signup/" class="btn-color"><strong>'.__('signup-now').'</strong></a>', VCfg::get('site_name'))); ?></h6>
        </div>    	
	  </div>
	  <div class="col-12 col-md-7 order-2 order-md-1">
		<form id="login-form" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/user/login/">
		  <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
          <div class="form-group row">
            <label for="username" class="col-sm-3 col-form-label"><?php echo __('username'); ?></label>
            <div class="col-sm-9">
              <input name="username" type="text" class="form-control" id="username" maxlength="<?php echo VCfg::get('user.username_max_length'); ?>" value="<?php echo e($this->signup['username']); ?>">
            </div>
          </div>
          <div class="form-group row">
            <label for="password" class="col-sm-3 col-form-label"><?php echo __('password'); ?></label>
            <div class="col-sm-9">
              <input name="password" type="password" class="form-control" id="password" maxlength="<?php echo VCfg::get('user.password_max_length'); ?>">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
          	  <div class="custom-control custom-checkbox">
          		<input name="remember" type="checkbox" class="custom-control-input" id="remember" value="1">
				<label class="custom-control-label" for="remember"><?php echo __('remember-me-on-this-computer'); ?></label>
			  </div>
			</div>
		  </div>
		  <div class="form-group row">
			<div class="col-sm-9 offset-sm-3">
			  <a href="<?php echo REL_URL.LANG; ?>/user/lost/" class="btn-link"><?php echo __('lost-question'); ?></a><br>
              <a href="<?php echo REL_URL.LANG; ?>/user/confirm/" class="btn-link"><?php echo __('confirm-question'); ?></a>
            </div>
          </div>            
          <div class="offset-sm-3">
            <button type="submit" name="submit_login" id="submit-login" class="btn btn-primary btn-lg ml-1"><?php echo __('login'); ?></button>
          </div>
		</form>
	  </div>
	</div>
  </div>
</div>