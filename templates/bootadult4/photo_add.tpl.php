<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_photo_add.js'; ?>
<h1><?php echo e($this->title); ?></h1>
<div class="row">
  <div class="col-12 col-md-4 col-lg-3 order-1 order-md-2">
    <div class="border rounded-lg p-2">
  	  <h3><?php echo e(__('photo-upload-rules')); ?></h3>
      <ul class="nav flex-column">
      <?php $extensions = explode(',', VCfg::get('photo.allowed_extensions')); ?>
      <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('photo-rule-1', VCfg::get('photo.max_size')); ?></li>
      <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('photo-rule-2', implode(', ', $extensions)); ?></li>
      <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('photo-rule-3', VCfg::get('photo.max_categories')); ?></li>
      <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('photo-rule-4'); ?></li>
      <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('photo-rule-5'); ?></li>
      <?php for ($i=6; $i<=10; $i++): $text = __('photo-rule-'.$i); if ($text != 'photo-rule-'.$i): ?>
      <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo $text; ?></li>
      <?php endif; endfor; ?>
      </ul>  	  
	</div>
  </div>
  <div class="col-12 col-md-8 col-lg-9 order-2 order-md-1">
    <form id="upload-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL,LANG,'/photo/add/',$this->album_id; ?>/">
      <input name="upload_submitted" type="hidden" value="<?php echo time(); ?>">
      <input name="unique_id" type="hidden" value="<?php echo $this->unique; ?>">
      <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
      <p class="p2"><?php echo __('add-photos-to-album-help', VCfg::get('site_name')); ?></p>
      <div id="file-group" class="form-group row">
        <label for="file" class="col-sm-3 col-form-label"><?php echo __('files'); ?></label>
        <div class="col-sm-3 col-md-3 col-lg-3">
          <div id="upload-container">
            <input name="files" type="file" id="files">
            <div id="errors" class="help-block text-danger"></div>
          </div>
        </div>
        <div id="details" class="col-sm-9 offset-sm-3" style="display: none;">
          <div id="properties" style="display: block; padding: 5px 0;"></div>
          <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-9 offset-sm-3">
          <button type="button" id="upload" class="btn btn-lg rounded-pill btn-primary"><?php echo __('upload'); ?></button>
        </div>
      </div>
    </form>
  </div>
</div>
