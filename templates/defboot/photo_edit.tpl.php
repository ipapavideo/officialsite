<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_photo_album_edit.js'; $yesno = array(1 => __('yes'), 0 => __('no')); ?>
	  <div id="content">
		<h1><?php echo e($this->title); ?></h1>
		<div class="left left-full">
		  <?php if ($this->album): ?>
		  <form id="edit-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL,LANG,'/photo/edit/',$this->album_id; ?>/">
            <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
            <div id="title-group" class="form-group">
          	  <label for="title" class="col-sm-2 control-label"><?php echo __('title'); ?></label>
              <div class="col-sm-10">
            	<input name="title" type="text" class="form-control" id="title" value="<?php echo e($this->album['title']); ?>">
              </div>
            </div>		  
            <div id="description-group" class="form-group">
          	  <label for="description" class="col-sm-2 control-label"><?php echo __('description'); ?></label>
              <div class="col-sm-10">
            	<textarea name="description" class="form-control" id="description" rows="3"><?php echo e($this->album['description']); ?></textarea>
              </div>
            </div>
            <div id="categories-group" class="form-group">
          	  <label for="categories" class="col-sm-2 control-label"><?php echo __('categories'); ?></label>
              <div class="col-sm-10">
            	<select name="categories[]" id="categories" class="form-control" multiple="multiple">
              	  <option value="">Please select...</option>
                  <?php echo p('categories_select', array(), $this->album['categories'], 'photo'); ?>
                </select>
              </div>
            </div>          
            <div id="tags-group" class="form-group">
          	  <label for="tags" class="col-sm-2 control-label"><?php echo __('tags'); ?></label>
              <div class="col-sm-10">
            	<input name="tags" class="form-control" id="tags" value="<?php echo e($this->album['tags']); ?>">
              </div>
            </div>
            <div id="type-group" class="form-group">
          	  <label for="type" class="col-sm-2 control-label"><?php echo __('privacy'); ?></label>
              <div class="col-sm-10">            	
            	<?php echo VForm::inline('type', $this->types, $this->album['type']); ?>
              </div>
            </div>
            <div id="orientation-group" class="form-group">
              <label for="orientation" class="col-sm-2 control-label"><?php echo __('orientation'); ?></label>
              <div class="col-sm-10">
                <?php echo VForm::inline('orientation', $this->orientations, $this->album['orientation'], array('translate' => true)); ?>
              </div>
            </div>            
            <?php if (VModule::enabled('model')): ?>
            <div id="models-group" class="form-group">
          	  <label for="models" class="col-sm-2 control-label"><?php echo __('models'); ?></label>
              <div class="col-sm-10">
            	<select name="models[]" id="models" class="form-control" multiple="multiple">
                  <?php if ($this->album['models']): $models = explode(',', $this->album['models']); $names = explode(',', $this->album['names']); foreach ($models as $index => $model_id): ?>
                  <option value="<?php echo $model_id; ?>" selected="selected"><?php echo e($names[$index]); ?></option>
                  <?php endforeach; endif; ?>
                </select>
                <span id="categories-error" class="help-block text-danger"></span>              
              </div>
            </div>          
            <?php endif; ?>
            <?php if ($this->channels): ?>
            <div id="categories-group" class="form-group">
          	  <label for="categories" class="col-sm-2 control-label"><?php echo __('channel'); ?></label>
              <div class="col-sm-10">
            	<select name="channel_id" id="channel_id" class="form-control select2">
              	  <option value="">Please select...</option>
              	  <?php foreach ($this->channels as $channel): echo VForm::option($channel['name'], $channel['channel_id'], $this->album['channel_id']); endforeach; ?>
                </select>
                <span id="channel-error" class="help-block text-danger"></span>              
              </div>
            </div>
            <?php endif; ?>          
            <div id="thumb-group" class="form-group">
          	  <label for="thumb" class="col-sm-2 control-label"><?php echo __('cover'); ?></label>
              <div class="col-sm-10">
            	<span class="help-block"><?php echo __('cover-help'); ?></span>
            	<input name="cover_id" type="hidden" value="<?php echo $this->album['cover_id']; ?>">
            	<?php foreach ($this->photos as $photo): ?>
				<img src="<?php echo PHOTO_THUMB_URL,'/',$photo['photo_id']; ?>.jpg?rand=<?php echo rand(0, 1000); ?>" data-photo="<?php echo $photo['photo_id']; ?>" id="photo-<?php echo $photo['photo_id']; ?>" class="<?php if ($this->album['cover_id'] == $photo['photo_id']): echo 'img-rounded'; else: echo 'img-thumbnail'; endif; ?>" alt="" width="83" />
                <?php endforeach; ?>            	
              </div>
            </div>            
            <div class="col-sm-offset-2">
          	  <button type="submit" name="submit_edit" id="submit-edit" class="btn btn-submit"><?php echo __('save-changes'); ?></button>
          	  <button type="button" class="btn btn-menu"><?php echo __('cancel'); ?></button>
            </div>
		  </form>
		  <?php else: ?>
		  <div class="none">Invalid photo!</div>
		  <?php endif; ?>
		</div>
		<div class="clearfix"></div>
	  </div>
	  