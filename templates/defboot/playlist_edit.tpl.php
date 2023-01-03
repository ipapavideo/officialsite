<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_playlist_edit.js'; $yesno = array(1 => __('yes'), 0 => __('no')); ?>
	  <div id="content">
		<h1><?php echo e($this->title); ?></h1>
		<div class="left left-full">
		  <form id="edit-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL,LANG,'/playlist/edit/',$this->playlist_id; ?>/">
            <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
            <div id="title-group" class="form-group">
          	  <label for="name" class="col-sm-2 control-label"><?php echo __('name'); ?></label>
              <div class="col-sm-10">
            	<input name="name" type="text" class="form-control" id="name" value="<?php echo e($this->playlist['name']); ?>">
              </div>
            </div>		  
            <div id="description-group" class="form-group">
          	  <label for="description" class="col-sm-2 control-label"><?php echo __('description'); ?></label>
              <div class="col-sm-10">
            	<textarea name="description" class="form-control" id="description" rows="5"><?php echo e($this->playlist['description']); ?></textarea>
              </div>
            </div>
            <div id="tags-group" class="form-group">
          	  <label for="tags" class="col-sm-2 control-label"><?php echo __('tags'); ?></label>
              <div class="col-sm-10">
            	<input name="tags" class="form-control" id="tags" value="<?php echo e($this->playlist['tags']); ?>">
              </div>
            </div>
            <div id="type-group" class="form-group">
          	  <label for="type" class="col-sm-2 control-label"><?php echo __('privacy'); ?></label>
              <div class="col-sm-10">
            	<?php echo VForm::inline('type', $this->types, $this->playlist['type']); ?>
              </div>
            </div>
            <div id="comment-group" class="form-group">
          	  <label for="allow_comment" class="col-sm-2 control-label"><?php echo __('allow-comment'); ?></label>
              <div class="col-sm-10">
            	<?php echo VForm::inline('allow_comment', $yesno, $this->playlist['allow_comment']); ?>
              </div>
            </div>
            <div class="form-group">
          	  <label for="thumb_id" class="col-sm-2 control-label"><?php echo __('thumb'); ?></label>
              <div class="col-sm-10">
                <span class="help-block"><?php echo __('playlist-thumb-help'); ?></span>
                <input name="thumb_id" type="hidden" value="<?php echo $this->playlist['thumb_id']; ?>">              
          		<?php if ($this->videos): foreach ($this->videos as $video): ?>
          		<img src="<?php echo THUMB_URL,'/',path($video['video_id']),'/',$video['thumb'],'.jpg" alt="Thumb ',$video['video_id']; ?>" class="thumb<?php if ($video['video_id'] == $this->playlist['thumb_id']): echo ' thumb-active'; endif; ?>" data-nr="<?php echo $video['video_id']; ?>">
          		<?php endforeach; else: ?>
          		<div class="none"><?php echo __('no-videos'); ?></div>
          		<?php endif; ?>
          	  </div>
          	</div>
            <div class="col-sm-offset-2">
          	  <button type="submit" name="submit_edit" id="submit-edit" class="btn btn-submit"><?php echo __('save-changes'); ?></button>
          	  <button type="button" class="btn btn-menu"><?php echo __('cancel'); ?></button>
            </div>
		  </form>
		</div>
		<div class="clearfix"></div>
	  </div>
	  