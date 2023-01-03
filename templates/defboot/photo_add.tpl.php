<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_photo_add.js'; ?>
	  <div id="content">
		<h1><?php echo e($this->title); ?></h1>
		<div class="right">
		  <h3><?php echo __('upload-rules'); ?></h3>
		  <ul class="nav nav-stacked">
        	<li><i class="fa fa-check-square"></i> <?php echo __('photo-rule-1'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('photo-rule-2'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('photo-rule-3'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('photo-rule-4'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('photo-rule-5'); ?></li>
            <li><i class="fa fa-check-square"></i> <?php echo __('photo-rule-6'); ?></li>
		  </ul>
		</div>
		<div class="left">
		  <form id="upload-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL,LANG,'/photo/add/',$this->album_id; ?>/">
        	<input name="upload_submitted" type="hidden" value="<?php echo time(); ?>">
            <input name="unique_id" type="hidden" value="<?php echo $this->unique; ?>">
            <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
            <div class="help-block"><?php echo __('add-photos-to-album-help', VCfg::get('site_name')); ?></div>
            <div id="file-group" class="form-group">
          	  <label for="file" class="col-sm-2 control-label"><?php echo __('files'); ?></label>
              <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
            	<div id="upload-container">
              	  <input name="files" type="file" id="files">
                  <div id="errors" class="help-block text-danger"></div>
                </div>
              </div>
              <div id="details" class="col-sm-offset-2 col-sm-10" style="display: none;">
            	<div id="properties" style="display: block; padding: 5px 0;"></div>
                <div class="progress">
              	  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
              </div>
            </div>
            <div class="col-sm-offset-2">
          	  <button type="button" id="upload" class="btn btn-submit"><?php echo __('upload'); ?></button>
            </div>
		  </form>
		</div>
		<div class="clearfix"></div>
	  </div>
