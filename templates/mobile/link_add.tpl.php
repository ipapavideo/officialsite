<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_link_add.js'; ?>
	  <div id="content">
		<h1><?php echo __('link-title'); ?></h1>
		<div class="right">
		  <h3><?php echo __('link-exchange-rules'); ?></h3>
		  <ul class="nav nav-stacked">
        	<li><i class="fa fa-check-square"></i> <?php echo __('link-rule-1'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('link-rule-2'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('link-rule-3'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('link-rule-4'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('link-rule-5'); ?></li>
		  </ul>
		</div>
		<div class="left">
		  <form id="link-add-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL.LANG; ?>/link/add/">
			<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
            <div class="form-group">
              <label for="title" class="col-sm-3 control-label"><?php echo __('site-title'); ?></label>
              <div class="col-sm-9">
            	<input name="title" type="text" class="form-control" maxlength="255" value="<?php echo e($this->link['title']); ?>">
              </div>
            </div>			
            <div class="form-group">
              <label for="description" class="col-sm-3 control-label"><?php echo __('site-description'); ?></label>
              <div class="col-sm-9">
            	<input name="description" type="text" class="form-control" maxlength="255" value="<?php echo e($this->link['description']); ?>">
              </div>
            </div>			
            <div class="form-group">
              <label for="url" class="col-sm-3 control-label"><?php echo __('site-url'); ?></label>
              <div class="col-sm-9">
            	<input name="url" type="text" class="form-control" maxlength="255" value="<?php echo $this->link['url']; ?>">
              </div>
            </div>			
            <div class="form-group">
              <label for="linkback" class="col-sm-3 control-label"><?php echo __('linkback-url'); ?></label>
              <div class="col-sm-9">
            	<input name="linkback" type="text" class="form-control" maxlength="255" value="<?php echo $this->link['linkback']; ?>">
              </div>
            </div>			
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label"><?php echo __('webmaster-name'); ?></label>
              <div class="col-sm-9 col-md-6 col-lg-5">
                <input name="name" type="text" class="form-control" id="name" maxlength="255" value="<?php echo e($this->link['name']); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label"><?php echo __('webmaster-email'); ?></label>
              <div class="col-sm-9 col-md-7 col-lg-7">
                <input name="email" type="text" class="form-control" id="email" maxlength="255" value="<?php echo e($this->link['email']); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="verification" class="col-sm-3 control-label"></label>
              <div class="col-sm-9 col-md-4 col-lg-3">
				<div class="g-recaptcha" data-sitekey="<?php echo VCfg::get('recaptcha_site_key'); ?>" id="recaptcha" data-theme="dark"></div>
              </div>
            </div>
            <div class="col-sm-offset-3">
          	  <button type="submit" name="submit_add" id="submit-add" class="btn btn-submit"><?php echo __('add-link'); ?></button>
            </div>
		  </form>
		</div>
		<div class="clearfix"></div>
	  </div>
	  