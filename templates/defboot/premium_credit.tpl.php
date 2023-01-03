<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_signup.js'; ?>
	  <div id="content">
		<h1><?php echo e($this->title); ?></h1>
		<div class="right">
		  <h3><?php echo __('upgrade-reasons-title'); ?></h3>
		  <ul class="nav nav-stacked">
        	<li><i class="fa fa-check-square"></i> <?php echo __('register-reason-1'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('register-reason-2'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('register-reason-3'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('register-reason-4'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('register-reason-5'); ?></li>
		  </ul>
		</div>
		<div class="left">
		  <form id="register-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/premium/credit/">
			<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
			<input name="system" type="hidden" value="<?php echo $this->system; ?>">
            <?php if ($this->methods): ?>
            <div class="form-group">
              <label for="method_id" class="col-sm-2 control-label"><?php echo __('payment-method'); ?></label>
              <div class="col-sm-10">
            	<?php foreach ($this->methods as $method): ?>
            	<div class="radio radio-inline"><input name="method_id" type="radio" id="method_id-<?php echo $method['method_id']; ?>" value="<?php echo $method['method_id']; ?>"<?php if ($method['position'] <= 1): echo ' checked="checked"'; endif; ?>> <label><?php echo __($method['translation']); ?></label></div>
            	<?php endforeach; ?>
              </div>
            </div>            
            <?php endif; ?>            
            <div class="form-group">
              <label for="credit" class="col-sm-2 control-label"><?php echo __('credit'); ?></label>
              <div class="col-sm-10 col-md-2 col-lg-1">
                <input name="credit" type="text" class="form-control" id="email" maxlength="5" value="<?php echo $this->amount; ?>">
              </div>
              <span class="help-inline"><?php echo $this->currency; ?></span>
            </div>
            <div class="form-group">
          	  <div class="col-sm-10 col-sm-offset-2">
          		<div class="checkbox"><?php echo VForm::checkbox('terms_confirm', 'on', $this->signup['terms_confirm']); ?> <label><?php echo __('terms-confirm', array('<a href="'.REL_URL.LANG.'/static/terms/" class="btn-color">'.__('terms-and-conditions').'</a>', '<a href="'.REL_URL.LANG.'/static/privacy/" class="btn-color">'.__('privacy-policy').'</a>')); ?></label></div>
          	  </div>
            </div>			
            <div class="col-sm-offset-2 col-center">
          	  <button type="submit" name="submit_credit" id="submit-credit" class="btn btn-submit"><?php echo __('add-credit'); ?></button>
            </div>
		  </form>
		</div>
		<div class="clearfix"></div>
	  </div>
	  