<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_upload.js'; ?>
	  <div id="content">
		<h1><?php echo e($this->title); if (VModule::enabled('photo')): ?> <a href="<?php echo REL_URL; ?>/photo/upload/" class="btn btn-xs btn-submit pull-right"><?php echo __('upload-photos'); ?></a><?php endif; ?></h1>
		<div class="right">
		  <h3><?php echo e(__('upload-rules')); ?></h3>
		  <ul class="nav nav-stacked">
			<?php $extensions = explode(',', VCfg::get('video.allowed_extensions')); ?>
        	<li><i class="fa fa-check-square"></i> <?php echo __('video-rule-1', VCfg::get('video.max_size')); ?></li>
        	<li><i class="fa fa-check-square"></i> <?php echo __('video-rule-2', implode(', ', $extensions)); ?></li>
        	<li><i class="fa fa-check-square"></i> <?php echo __('video-rule-3', VCfg::get('video.max_categories')); ?></li>
        	<li><i class="fa fa-check-square"></i> <?php echo __('video-rule-4'); ?></li>
        	<li><i class="fa fa-check-square"></i> <?php echo __('video-rule-5'); ?></li>
			<?php for ($i=6; $i<=10; $i++): $text = __('video-rule-'.$i); if ($text != 'video-rule-'.$i): ?>
        	<li><i class="fa fa-check-square"></i> <?php echo $text; ?></li>
			<?php endif; endfor; ?>
		  </ul>
		</div>
		<div class="left">
		  <form id="upload-form" class="form-horizontal" role="form" method="post" action="<?php echo video_url(true); ?>/upload/">
        	<input name="upload_submitted" type="hidden" value="<?php echo time(); ?>">
            <input name="unique_id" type="hidden" value="<?php echo $this->unique; ?>">
            <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
            <div id="title-group" class="form-group">
          	  <label for="title" class="col-sm-2 control-label"><?php echo __('title'); ?></label>
              <div class="col-sm-10">
            	<input name="title" type="text" class="form-control" id="title" value="<?php echo e($this->video['title']); ?>">
                <span id="title-error" class="help-block text-danger"></span>
              </div>
            </div>		  
            <div id="description-group" class="form-group">
          	  <label for="description" class="col-sm-2 control-label"><?php echo __('description'); ?></label>
              <div class="col-sm-10">
            	<textarea name="description" class="form-control" id="description" rows="3"><?php echo e($this->video['description']); ?></textarea>
              </div>
            </div>
            <div id="categories-group" class="form-group">
          	  <label for="categories" class="col-sm-2 control-label"><?php echo __('categories'); ?></label>
              <div class="col-sm-10">
            	<select name="categories[]" id="categories" class="form-control" multiple="multiple">
              	  <option value="">Please select...</option>
                  <?php echo p('categories_select', array(), $this->video['categories']); ?>
                </select>
                <span id="categories-error" class="help-block text-danger"></span>              
              </div>
            </div>          
            <div id="tags-group" class="form-group">
          	  <label for="tags" class="col-sm-2 control-label"><?php echo __('tags'); ?></label>
              <div class="col-sm-10">
            	<input name="tags" class="form-control" id="tags" value="<?php echo e($this->video['tags']); ?>">
                <span id="tags-error" class="help-block text-danger"></span>              
              </div>
            </div>
            <div id="privacy-group" class="form-group">
          	  <label for="privacy" class="col-sm-2 control-label"><?php echo __('privacy'); ?></label>
              <div class="col-sm-10">
            	<?php echo VForm::inline('type', $this->types, $this->video['type']); ?>
              </div>
            </div>
            <?php if (VModule::enabled('model')): ?>
            <div id="models-group" class="form-group">
          	  <label for="models" class="col-sm-2 control-label"><?php echo __('models'); ?></label>
              <div class="col-sm-10">
            	<select name="models[]" id="models" class="form-control" multiple="multiple">
                  <?php if ($this->video['models']): foreach ($this->video['models'] as $model_id => $name): ?>
                  <option value="<?php echo $model_id; ?>" selected="selected"><?php echo e($name); ?></option>
                  <?php endforeach; endif; ?>
                </select>
                <span id="categories-error" class="help-block text-danger"></span>              
              </div>
            </div>          
            <?php endif; ?>
            <?php if ($this->channels): ?>
            <div id="categories-group" class="form-group">
          	  <label for="categories" class="col-sm-2 control-label"><?php echo __('channel'); ?></label>
              <div class="col-sm-10 col-md-5 col-lg-4">
            	<select name="channel_id" id="channel_id" class="form-control">
              	  <option value="">Please select...</option>
              	  <?php foreach ($this->channels as $channel): echo VForm::option($channel['name'], $channel['channel_id'], $this->video['channel_id']); endforeach; ?>
                </select>
                <span id="channel-error" class="help-block text-danger"></span>              
              </div>
            </div>
            <?php endif; ?>          
            <div id="file-group" class="form-group">
          	  <label for="file" class="col-sm-2 control-label"><?php echo __('file'); ?></label>
              <div class="col-sm-3 col-md-3 col-lg-3">
            	<div id="upload-container">
            	  <input name="file" type="file" id="file">
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
            <div class="col-sm-offset-2 col-center">
          	  <button type="button" id="upload" class="btn btn-submit"><?php echo __('upload'); ?></button>
            </div>
		  </form>
		</div>
		<div class="clearfix"></div>
	  </div>
	  