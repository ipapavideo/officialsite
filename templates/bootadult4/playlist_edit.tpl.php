<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_playlist_edit.js'; $yesno = array(1 => __('yes'), 0 => __('no')); ?>
<div class="row">
  <div class="col-12">
	<h1><?php echo e($this->title); ?></h1>
	<form id="edit-form" class="form-horizontal" role="form" method="post" action="<?php echo REL_URL,LANG,'/playlist/edit/',$this->playlist_id; ?>/">
  	  <input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
      <div id="title-group" class="form-group row">
    	<label for="name" class="col-sm-2 col-form-label"><?php echo __('name'); ?></label>
        <div class="col-sm-10">
      	  <input name="name" type="text" class="form-control" id="name" value="<?php echo e($this->playlist['name']); ?>">
        </div>
      </div>
      <div id="description-group" class="form-group row">
        <label for="description" class="col-sm-2 col-form-label"><?php echo __('description'); ?></label>
        <div class="col-sm-10">
          <textarea name="description" class="form-control" id="description" rows="3"><?php echo e($this->playlist['description']); ?></textarea>
        </div>
      </div>
      <div id="tags-group" class="form-group row">
        <label for="tags" class="col-sm-2 col-form-label"><?php echo __('tags'); ?></label>
        <div class="col-sm-10">
          <input name="tags" class="form-control" id="tags" value="<?php echo e($this->playlist['tags']); ?>" style="width: 100%;">
        </div>
      </div>
      <div id="type-group" class="form-group row">
        <label for="type" class="col-sm-2 col-form-label"><?php echo __('privacy'); ?></label>
        <div class="col-sm-10">
          <?php echo VForm4::radiosInline('type', $this->types, $this->playlist['type']); ?>
        </div>
      </div>
      <div id="comment-group" class="form-group row">
        <label for="allow_comment" class="col-sm-2 col-form-label"><?php echo __('allow-comment'); ?></label>
        <div class="col-sm-10">
          <?php echo VForm4::radiosInline('allow_comment', $yesno, $this->playlist['allow_comment']); ?>
        </div>
      </div>
	  <div id="thumb-group" class="form-group row">
  		<label for="thumb" class="col-sm-2 col-form-label"><?php echo __('thumb'); ?></label>
  		<div class="col-sm-10">
    	  <span class="form-text text-muted"><?php echo __('playlist-thumb-help'); ?></span>
    	  <input name="thumb_id" type="hidden" value="<?php echo $this->playlist['thumb_id']; ?>">
    	  <?php if ($this->videos): foreach ($this->videos as $video): ?>
    	  <img src="<?php echo THUMB_URL,'/',path($video['video_id']),'/',$video['thumb'],'.jpg" alt="Thumb ',$video['video_id']; ?>" class="playlist-image mb-1 border<?php if ($video['video_id'] == $this->playlist['thumb_id']): echo ' border-primary'; endif; ?>" data-nr="<?php echo $video['video_id']; ?>" width="160">
    	  <?php endforeach; else: ?>
    	  <div class="none"><?php echo __('no-videos'); ?></div>
    	  <?php endif; ?>
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
