<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_photo_album_edit.js'; $yesno = array(1 => __('yes'), 0 => __('no')); ?>
<div class="row">
  <div class="col-12">
	<h1><?php echo e($this->title); ?></h1>
    <form id="edit-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL,LANG,'/photo/edit/',$this->album_id; ?>/">
      <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
      <div id="title-group" class="form-group row">
        <label for="title" class="col-sm-2 col-form-label"><?php echo __('title'); ?></label>
        <div class="col-sm-10">
          <input name="title" type="text" class="form-control" id="title" value="<?php echo e($this->album['title']); ?>">
          <small id="title-error" class="form-text text-danger"></small>
        </div>
      </div>
      <div id="description-group" class="form-group row">
        <label for="description" class="col-sm-2 col-form-label"><?php echo __('description'); ?></label>
        <div class="col-sm-10">
          <textarea name="description" class="form-control" id="description" rows="3"><?php echo e($this->album['description']); ?></textarea>
        </div>
      </div>
      <div id="categories-group" class="form-group row">
        <label for="categories" class="col-sm-2 col-form-label"><?php echo __('categories'); ?></label>
        <div class="col-sm-10">
          <select name="categories[]" id="categories" class="selectpicker form-control" multiple>
            <?php echo p('categories_select', array(), $this->album['categories'], 'photo'); ?>
          </select>
          <small id="categories-error" class="form-text text-danger"></small>
        </div>
      </div>
      <div id="tags-group" class="form-group row">
        <label for="tags" class="col-sm-2 col-form-label"><?php echo __('tags'); ?></label>
        <div class="col-sm-10">
          <input name="tags" class="form-control" id="tags" value="<?php echo e($this->album['tags']); ?>" style="width: 100%;">
          <small id="tags-error" class="form-text text-danger"></small>
        </div>
      </div>
      <div id="orientation-group" class="form-group row">
    	<label for="orientation" class="col-sm-2 form-control-label"><?php echo __('orientation'); ?></label>
        <div class="col-sm-10">
      	  <?php echo VForm4::radiosInline('orientation', $this->orientations, $this->album['orientation'], array('translate' => true)); ?>
        </div>
      </div>      
      <div id="type-group" class="form-group row">
        <label for="type" class="col-sm-2 col-form-label"><?php echo __('privacy'); ?></label>
        <div class="col-sm-10">
          <?php echo VForm4::radiosInline('type', $this->types, $this->album['type']); ?>
        </div>
      </div>
      <?php if (VModule::enabled('model')): ?>
      <div id="models-group" class="form-group row">
        <label for="models" class="col-sm-2 col-form-label"><?php echo __('models'); ?></label>
        <div class="col-sm-10">
          <select name="models[]" id="models" class="form-control" multiple="multiple">
            <?php if ($this->album['models']): $models = explode(',', $this->album['models']); $names = explode(',', $this->album['names']); foreach ($models as $index => $model_id): ?>
            <option value="<?php echo $model_id; ?>" selected="selected"><?php echo e($names[$index]); ?></option>
            <?php endforeach; endif; ?>
          </select>
          <small id="models-error" class="form-text text-danger"></small>
        </div>
      </div>
      <?php endif; if ($this->channels): ?>
      <div id="categories-group" class="form-group row">
        <label for="categories" class="col-sm-2 col-form-label"><?php echo __('channel'); ?></label>
        <div class="col-sm-10">
          <select name="channel_id" id="channel_id" class="form-control select2">
            <option value="">Please select...</option>
            <?php foreach ($this->channels as $channel): echo VForm::option($channel['name'], $channel['channel_id'], $this->album['channel_id']); endforeach; ?>
          </select>
          <small id="channel-error" class="form-text text-danger"></small>
        </div>
      </div>
      <?php endif; ?>
      <div id="thumb-group" class="form-group row">
        <label for="thumb" class="col-sm-2 col-form-label"><?php echo __('cover'); ?></label>
        <div class="col-sm-10">
          <span class="form-text text-muted"><?php echo __('cover-help'); ?></span>
          <input name="cover_id" type="hidden" value="<?php echo $this->album['cover_id']; ?>">
          <?php foreach ($this->photos as $photo): ?>
          <img src="<?php echo PHOTO_THUMB_URL,'/',$photo['photo_id']; ?>.jpg?rand=<?php echo rand(0, 1000); ?>" alt="" class="video-image mb-1 border<?php if ($this->album['cover_id'] == $photo['photo_id']): echo ' border-primary rounded-pill'; endif; ?>" data-photo="<?php echo $photo['photo_id']; ?>" id="photo-<?php echo $photo['photo_id']; ?>" width="100">
          <?php endforeach; ?>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
          <button type="submit" name="submit_edit" id="submit-edit" class="btn btn-lg rounded-pill btn-primary"><?php echo __('save-changes'); ?></button>
        </div>
      </div>
    </form>
  </div>
</div>
