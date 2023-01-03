<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (isset($this->pagination)): ?>
<div class="row">
  <div class="col-12">
	<h2><?php echo e($this->title); ?></h2>
    <?php if ($this->playlists): echo p('playlists', $this->playlists); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php echo __('no-playlists'); ?>
    <?php endif; ?>
  </div>
</div>
<?php else: if (isset($this->total_public_playlists) and $this->total_public_playlists): ?>
<div class="row mt-2">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-public-playlists-title', $this->username); ?> <small>(<?php echo $this->total_public_playlists; ?>)</small></h3>
      </div>
      <?php if ($this->total_public_playlists > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/playlists/public/" class="btn btn-sm btn-light rounded-pill"><i class="fa fa-plus"></i> <?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('playlists', $this->public_playlists); ?>
  </div>
</div>
<?php endif; if (isset($this->total_private_playlists) and $this->total_private_playlists): ?>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-private-playlists-title', $this->username); ?> <small>(<?php echo $this->total_private_playlists; ?>)</small></h3>
      </div>
      <?php if ($this->total_private_playlists > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/playlists/private/" class="btn btn-sm btn-light rounded-pill"><i class="fa fa-plus"></i> <?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('playlists', $this->private_playlists); ?>
  </div>
</div>
<?php endif; if (isset($this->total_favorite_playlists) and $this->total_favorite_playlists): ?>
<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('profile-favorite-playlists-title', $this->username); ?> <small>(<?php echo $this->total_favorite_playlists; ?>)</small></h3>
      </div>
      <?php if ($this->total_favorite_playlists > 6): ?>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG,'/users/',$this->username; ?>/playlists/favorite/" class="btn btn-sm btn-light rounded-pill"><i class="fa fa-plus"></i> <?php echo __('view-all'); ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php echo p('playlists', $this->favorite_playlists); ?>
  </div>
</div>
<?php endif; endif; ?>
