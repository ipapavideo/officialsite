<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (isset($this->pagination)): ?>
<div class="row">
  <div class="col-12">
	<h2><?php echo e($this->title); ?></h2>
    <?php if ($this->videos): echo p('videos', $this->videos); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php echo __('no-videos'); ?>
    <?php endif; ?>
  </div>
</div>
<?php else: if (isset($this->total_public_videos) and $this->total_public_videos): ?>
<div class="row mt-2">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-public-videos-title', $this->username); ?> <small>(<?php echo $this->total_public_videos; ?>)</small></h3>
      </div>
      <?php if ($this->total_public_videos > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/public/" class="btn btn-sm btn-light rounded-pill"><i class="fa fa-plus"></i> <?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('videos', $this->public_videos); ?>
  </div>
</div>
<?php endif; if (isset($this->total_private_videos) and $this->total_private_videos): ?>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-private-videos-title', $this->username); ?> <small>(<?php echo $this->total_private_videos; ?>)</small></h3>
      </div>
      <?php if ($this->total_private_videos > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/private/" class="btn btn-sm btn-light rounded-pill"><i class="fa fa-plus"></i> <?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('videos', $this->private_videos); ?>
  </div>
</div>
<?php endif; if (isset($this->total_favorite_videos) and $this->total_favorite_videos): ?>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-favorite-videos-title', $this->username); ?> <small>(<?php echo $this->total_favorite_videos; ?>)</small></h3>
      </div>
      <?php if ($this->total_favorite_videos > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/favorite/" class="btn btn-sm btn-light rounded-pill"><i class="fa fa-plus"></i> <?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('videos', $this->favorite_videos); ?>
  </div>
</div>
<?php endif; if (isset($this->total_history_videos) and $this->total_history_videos): ?>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-history-videos-title', $this->username); ?> <small>(<?php echo $this->total_history_videos; ?>)</small></h3>
      </div>
      <?php if ($this->total_history_videos > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/videos/history/" class="btn btn-sm btn-light rounded-pill"><i class="fa fa-plus"></i> <?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('videos', $this->history_videos); ?>
  </div>
</div>
<?php endif; endif; ?>


