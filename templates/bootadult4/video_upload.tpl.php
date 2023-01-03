<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_upload.js'; $yesno = array(1 => __('yes'), 0 => __('no')); $photo = VModule::enabled('photo'); ?>
<div class="row">
  <div class="col-12 col-md-7 text-center text-md-left">
    <h1><?php echo e($this->title); ?></h1>
  </div>
  <?php if ($photo): ?>
  <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center mb-2">
	<a href="<?php echo REL_URL; ?>/photo/upload/" class="btn btn-primary rounded-pill"><?php echo __('upload-photos'); ?></a>
  </div>
  <?php endif; ?>
</div>
<div class="row">
  <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 order-1 order-md-2 mb-3">
	<div class="border rounded-lg p-2">
	  <h4><?php echo e(__('upload-rules')); ?></h4>
	  <ul class="nav flex-column">
		<?php $extensions = explode(',', VCfg::get('video.allowed_extensions')); ?>
		<li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('video-rule-1', VCfg::get('video.max_size')); ?></li>
        <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('video-rule-2', implode(', ', $extensions)); ?></li>
        <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('video-rule-3', VCfg::get('video.max_categories')); ?></li>
        <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('video-rule-4'); ?></li>
        <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo __('video-rule-5'); ?></li>
        <?php for ($i=6; $i<=10; $i++): $text = __('video-rule-'.$i); if ($text != 'video-rule-'.$i): ?>
        <li class="nav-item"><i class="fa fa-check-square"></i> <?php echo $text; ?></li>
        <?php endif; endfor; ?>
	  </ul>
	</div>
  </div>
  <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 order-2 order-md-1">
    <form id="upload-form" class="form-horizontal" role="form" method="post" action="<?php echo video_url(true); ?>/upload/">
      <input name="upload_submitted" type="hidden" value="<?php echo time(); ?>">
      <input name="unique_id" type="hidden" value="<?php echo $this->unique; ?>">
      <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
      <div id="title-group" class="form-group row">
    	<label for="title" class="col-sm-3 col-form-label"><?php echo __('title'); ?></label>
        <div class="col-sm-9">
      	  <input name="title" type="text" class="form-control" id="title" value="<?php echo e($this->video['title']); ?>">
      	  <small id="title-error" class="form-text text-danger"></small>
        </div>
      </div>
      <div id="description-group" class="form-group row">
        <label for="description" class="col-sm-3 col-form-label"><?php echo __('description'); ?></label>
        <div class="col-sm-9">
          <textarea name="description" class="form-control" id="description" rows="3"><?php echo e($this->video['description']); ?></textarea>
        </div>
      </div>
      <div id="categories-group" class="form-group row">
        <label for="categories" class="col-sm-3 col-form-label"><?php echo __('categories'); ?></label>
        <div class="col-sm-9">
          <select name="categories[]" id="categories" class="selectpicker form-control" multiple>
            <?php echo p('categories_select', array(), $this->video['categories']); ?>
          </select>
          <small id="categories-error" class="form-text text-danger"></small>
        </div>
      </div>
      <div id="tags-group" class="form-group row">
        <label for="tags" class="col-sm-3 col-form-label"><?php echo __('tags'); ?></label>
        <div class="col-sm-9">
          <input name="tags" class="form-control" id="tags" value="<?php echo e($this->video['tags']); ?>" style="width: 100%;">
          <small id="tags-error" class="form-text text-danger"></small>
        </div>
      </div>
      <div id="type-group" class="form-group row">
        <label for="type" class="col-sm-3 col-form-label"><?php echo __('privacy'); ?></label>
        <div class="col-sm-9">
          <?php echo VForm4::radiosInline('type', $this->types, $this->video['type']); ?>
        </div>
      </div>
      <?php if (VModule::enabled('model')): ?>
      <div id="models-group" class="form-group row">
        <label for="models" class="col-sm-3 col-form-label"><?php echo __('models'); ?></label>
        <div class="col-sm-9">
          <select name="models[]" id="models" class="form-control" multiple="multiple">
            <?php if ($this->video['models']): $models = explode(',', $this->video['models']); $names = explode(',', $this->video['names']); foreach ($models as $index => $model_id): ?>
            <option value="<?php echo $model_id; ?>" selected="selected"><?php echo e($names[$index]); ?></option>
            <?php endforeach; endif; ?>
          </select>
          <small id="models-error" class="form-text text-danger"></small>
        </div>
      </div>
      <?php endif; if ($this->channels): ?>
      <div id="categories-group" class="form-group row">
        <label for="categories" class="col-sm-3 col-form-label"><?php echo __('channel'); ?></label>
        <div class="col-sm-9">
          <select name="channel_id" id="channel_id" class="form-control select2">
            <option value="">Please select...</option>
            <?php foreach ($this->channels as $channel): echo VForm::option($channel['name'], $channel['channel_id'], $this->video['channel_id']); endforeach; ?>
          </select>
          <small id="channel-error" class="form-text text-danger"></small>
        </div>
      </div>
      <?php endif; ?>
      <div id="file-group" class="form-group row">
        <label for="file" class="col-sm-3 col-form-label"><?php echo __('file'); ?></label>
        <div class="col-sm-3 col-md-3 col-lg-3">
          <div id="upload-container">
            <input name="file" type="file" id="file">
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
