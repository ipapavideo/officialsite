<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_edit.js'; $yesno = array(1 => __('yes'), 0 => __('no')); ?>
<div class="row">
  <div class="col-12">
	<h1><?php echo e($this->title); ?></h1>
	<form id="edit-form" class="form-horizontal" role="form" method="post" action="<?php echo video_url(true); ?>/edit/<?php echo $this->video_id; ?>/">
  	  <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
      <div id="title-group" class="form-group row">
    	<label for="title" class="col-sm-2 col-form-label"><?php echo __('title'); ?></label>
        <div class="col-sm-10">
      	  <input name="title" type="text" class="form-control" id="title" value="<?php echo e($this->video['title']); ?>">
        </div>
      </div>
      <div id="description-group" class="form-group row">
        <label for="description" class="col-sm-2 col-form-label"><?php echo __('description'); ?></label>
        <div class="col-sm-10">
          <textarea name="description" class="form-control" id="description" rows="3"><?php echo e($this->video['description']); ?></textarea>
        </div>
      </div>
      <div id="categories-group" class="form-group row">
        <label for="categories" class="col-sm-2 col-form-label"><?php echo __('categories'); ?></label>
        <div class="col-sm-10">
          <select name="categories[]" id="categories" class="selectpicker form-control" multiple>
            <?php echo p('categories_select', array(), $this->video['categories']); ?>
          </select>
        </div>
      </div>
      <div id="tags-group" class="form-group row">
        <label for="tags" class="col-sm-2 col-form-label"><?php echo __('tags'); ?></label>
        <div class="col-sm-10">
          <input name="tags" class="form-control" id="tags" value="<?php echo e($this->video['tags']); ?>" style="width: 100%;">
        </div>
      </div>
      <div id="type-group" class="form-group row">
        <label for="type" class="col-sm-2 col-form-label"><?php echo __('privacy'); ?></label>
        <div class="col-sm-10">
          <?php echo VForm4::radiosInline('type', $this->types, $this->video['type']); ?>
        </div>
      </div>
      <div id="embed-group" class="form-group row">
        <label for="allow_embed" class="col-sm-2 col-form-label"><?php echo __('allow-embed'); ?></label>
        <div class="col-sm-10">
          <?php echo VForm4::radiosInline('allow_embed', $yesno, $this->video['allow_embed']); ?>
        </div>
      </div>
      <div id="download-group" class="form-group row">
        <label for="allow_download" class="col-sm-2 col-form-label"><?php echo __('allow-download'); ?></label>
        <div class="col-sm-10">
          <?php echo VForm4::radiosInline('allow_download', $yesno, $this->video['allow_download']); ?>
        </div>
      </div>
      <div id="rating-group" class="form-group row">
        <label for="allow_rating" class="col-sm-2 col-form-label"><?php echo __('allow-rating'); ?></label>
        <div class="col-sm-10">
          <?php echo VForm4::radiosInline('allow_rating', $yesno, $this->video['allow_rating']); ?>
        </div>
      </div>
      <div id="comment-group" class="form-group row">
        <label for="allow_comment" class="col-sm-2 col-form-label"><?php echo __('allow-comment'); ?></label>
        <div class="col-sm-10">
          <?php echo VForm4::radiosInline('allow_comment', $yesno, $this->video['allow_comment']); ?>
        </div>
      </div>
      <?php if (VModule::enabled('model')): ?>
      <div id="models-group" class="form-group row">
        <label for="models" class="col-sm-2 col-form-label"><?php echo __('models'); ?></label>
        <div class="col-sm-10">
          <select name="models[]" id="models" class="form-control" multiple="multiple">
            <?php if ($this->video['models']): $models = explode(',', $this->video['models']); $names = explode(',', $this->video['names']); foreach ($models as $index => $model_id): ?>
            <option value="<?php echo $model_id; ?>" selected="selected"><?php echo e($names[$index]); ?></option>
            <?php endforeach; endif; ?>
          </select>
          <span id="categories-error" class="help-block text-danger"></span>
        </div>
      </div>
      <?php endif; if ($this->channels): ?>
      <div id="categories-group" class="form-group row">
        <label for="categories" class="col-sm-2 col-form-label"><?php echo __('channel'); ?></label>
        <div class="col-sm-10">
          <select name="channel_id" id="channel_id" class="form-control select2">
            <option value="">Please select...</option>
            <?php foreach ($this->channels as $channel): echo VForm::option($channel['name'], $channel['channel_id'], $this->video['channel_id']); endforeach; ?>
          </select>
          <span id="channel-error" class="help-block text-danger"></span>
        </div>
      </div>
      <?php endif; ?>
	  <div id="thumb-group" class="form-group row">
  		<label for="thumb" class="col-sm-2 col-form-label"><?php echo __('thumb'); ?></label>
  		<div class="col-sm-10">
    	  <span class="form-text text-muted"><?php echo __('thumb-help'); ?></span>
    	  <input name="thumb" type="hidden" value="<?php echo $this->video['thumb']; ?>">
    	  <?php for ($i=1; $i<=$this->video['thumbs']; $i++): ?>
    	  <img src="<?php echo THUMB_URL,'/',path($this->video_id),'/',$i,'.jpg" alt="Thumb ',$i; ?>" class="video-image mb-1 border<?php if ($i == $this->video['thumb']): echo ' border-primary'; endif; ?>" data-nr="<?php echo $i; ?>" width="160">
    	  <?php endfor; ?>
  		</div>
	  </div>
	  <div class="form-group row">
		<div class="col-sm-10 offset-sm-2">
		  <button type="submit" name="submit_edit" id="submit-edit" class="btn btn-lg btn-primary"><?php echo __('save-changes'); ?></button>
		</div>
	  </div>                  
	</form>
  </div>
</div>
