<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_signup.js'; ?>
  <h1 class="mb-4 text-center"><?php echo e($this->title); ?></h1>
  <div class="row justify-content-md-center">
	<div class="col-12 col-md-10 p-4 border rounded">
	  <div class="row">
		<div class="col-12 col-lg-4 order-1 order-lg-2 mb-5">
    	  <ul class="list-group">
    		<li class="list-group-item active"><h4><?php echo __('not-a-member-yet'); ?></h4></li>
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
		  <form id="signup-form" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/user/confirm/">
			<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
            <div class="form-group row">
              <label for="email" class="col-sm-3 col-form-label-lg"><?php echo __('email'); ?></label>
              <div class="col-sm-9">
                <input name="email" type="text" class="form-control" id="email" maxlength="255" value="<?php echo e($this->signup['email']); ?>">
              </div>
            </div>
            <div class="offset-sm-3">
              <button type="submit" name="submit_signup" id="submit-signup" class="btn btn-lg btn-primary ml-1"><?php echo __('sign-up'); ?></button>
            </div>
		  </form>
		</div>
	  </div>
	</div>
  </div>
