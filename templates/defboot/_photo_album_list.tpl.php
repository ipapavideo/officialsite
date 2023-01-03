<?php defined('_VALID') or die('Restricted Access!'); $upload = (VCfg::get('photo.upload')) ? true : false; ?>
<ul class="albums<?php if (isset($this->aclass)): echo ' '.$this->aclass; endif; ?>">
  <?php $loggedin = VAuth::loggedin(); $id = (isset($this->id)) ? '-'.$this->id : ''; $ids = array(); 
  foreach ($this->albums as $album): $ids[] = $album['album_id'];
  $percent	= ($album['percent']) ? round($album['percent']) : 100;
  $class	= ($percent >= 50) ? 'up' : 'down'; ?>
  <li id="album-<?php echo $album['album_id']; ?>" class="album">
	<a href="<?php echo album_url($album['album_id'], $album['slug']); ?>" title="<?php echo e($album['title']); ?>" class="image">
	  <div class="photo-thumb">
		<img src="<?php echo PHOTO_THUMB_URL,'/',$album['cover_id']; ?>.jpg" alt="<?php echo __('album-cover', $album['title']); ?>">
		<span class="duration"><i class="fa fa-camera"></i> <?php echo $album['total_photos']; ?></span>
		<?php if ($album['type'] == '1'): ?>
		<div class="private-overlay"><i class="fa fa-lock fa-2x"></i><br><?php echo __('private'); ?></div>
		<?php endif; ?>
	  </div>
	</a>
	<span class="title"><a href="<?php echo album_url($album['album_id'], $album['slug']); ?>" title="<?php echo e($album['title']); ?>"><?php echo e($album['title']); ?></a></span>
	<span class="views"><?php echo $album['total_views'],' '; if ($album['total_views'] == '1'): echo __('view'); else: echo __('views'); endif; ?></span>
	<span class="rating <?php echo $class; ?>"><i class="fa fa-thumbs-<?php echo $class; ?>"></i> <?php echo $percent; ?>%</span>
	<?php if (isset($this->colmenu)): ?>
	<div class="actions">
	  <?php if ($this->submenu == 'user-albums'): ?>
	  <a href="<?php echo REL_URL,LANG,'/photo/edit/',$album['album_id']; ?>/" class="btn btn-ns btn-warning"><?php echo __('edit'); ?></a>
	  <?php if ($upload): ?><a href="<?php echo REL_URL,LANG,'/photo/add/',$album['album_id']; ?>/" class="btn btn-ns btn-warning"><i class="fa fa-upload"></i></a><?php endif; ?>
	  <?php endif; ?>
	  <button class="btn-remove btn btn-ns btn-danger" data-id="<?php echo $album['album_id']; ?>" data-sub="<?php echo e($this->submenu); ?>"><?php echo __('delete'); ?></button>
	</div>
	<?php endif; ?>
  </li>
  <?php endforeach; p('ctr_albums', $ids); ?>
</ul>
<div class="clearfix"></div>
