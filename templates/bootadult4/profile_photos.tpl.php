<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (isset($this->pagination)): ?>
<div class="row">
  <div class="col-12">
	<h2><?php echo e($this->title); ?></h2>
    <?php if ($this->albums): echo p('albums', $this->albums); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php echo __('no-albums'); ?>
    <?php endif; ?>
  </div>
</div>
<?php else: if (isset($this->total_public_albums) and $this->total_public_albums): ?>
<div class="row mt-2">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-public-albums-title', $this->username); ?> <small>(<?php echo $this->total_public_albums; ?>)</small></h3>
      </div>
      <?php if ($this->total_public_albums > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/albums/public/" class="btn btn-xs btn-primary"><?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('albums', $this->public_albums); ?>
  </div>
</div>
<?php endif; if (isset($this->total_private_albums) and $this->total_private_albums): ?>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-private-albums-title', $this->username); ?> <small>(<?php echo $this->total_private_albums; ?>)</small></h3>
      </div>
      <?php if ($this->total_private_albums > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/albums/private/" class="btn btn-xs btn-primary"><?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('albums', $this->private_albums); ?>
  </div>
</div>
<?php endif; if (isset($this->total_favorite_photos) and $this->total_favorite_photos): ?>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-favorite-photos-title', $this->username); ?> <small>(<?php echo $this->total_favorite_photos; ?>)</small></h3>
      </div>
      <?php if ($this->total_favorite_photos > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/favorite/" class="btn btn-xs btn-primary"><?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('photos', $this->favorite_photos); ?>
  </div>
</div>
<?php endif; if (isset($this->total_history_photos) and $this->total_history_photos): ?>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-history-photos-title', $this->username); ?> <small>(<?php echo $this->total_history_photos; ?>)</small></h3>
      </div>
      <?php if ($this->total_history_photos > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/photos/history/" class="btn btn-xs btn-primary"><?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('photos', $this->history_photos); ?>
  </div>
</div>
<?php endif; endif; ?>
