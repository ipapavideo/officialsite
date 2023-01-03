<?php defined('_VALID') or die('Restricted Access!'); $del = VCfg::get('photo.allow_delete'); $a_user_id = (isset($this->album)) ? $this->album['user_id'] : 0; ?>
<ul class="photos<?php if (isset($this->pclass)): echo ' '.$this->pclass; endif; ?>">
  <?php $id = (isset($this->id)) ? '-'.$this->id : ''; $ids = array(); 
  foreach ($this->photos as $photo): $ids[] = $photo['photo_id'];
  $percent	= ($photo['percent']) ? round($photo['percent']) : 100;
  $class	= ($percent >= 50) ? 'up' : 'down'; 
  $user_id	= (isset($photo['user_id']) and $photo['user_id']) ? $photo['user_id'] : $a_user_id; ?>
  <li id="photo-<?php echo $photo['photo_id']; ?>" class="photo">
	<a href="<?php echo REL_URL,LANG,'/photo/',$photo['photo_id']; ?>/" title="<?php echo e($photo['caption']); ?>" class="image">
	  <div class="photo-thumb">
		<img src="<?php echo PHOTO_THUMB_URL,'/',$photo['photo_id']; ?>.jpg" alt="<?php echo __('photo-thumb', $photo['caption']); ?>">
		<?php if ($photo['type'] == '1'): ?>
		<div class="private-overlay"><i class="fa fa-lock fa-5x"></i></div>
		<?php endif; ?>
	  </div>
	</a>
	<span class="views"><?php echo $photo['total_views'],' '; if ($photo['total_views'] == '1'): echo __('view'); else: echo __('views'); endif; ?></span>
	<span class="rating <?php echo $class; ?>"><i class="fa fa-thumbs-<?php echo $class; ?>"></i> <?php echo $percent; ?>%</span>
	<?php if (isset($this->colmenu) or (isset($this->user_id) and $this->user_id == $user_id and $del)): ?>
	<div class="actions">
	  <button class="btn-remove btn btn-ns btn-danger" data-id="<?php echo $photo['photo_id']; ?>" data-sub="<?php echo e($this->submenu); ?>"><?php echo __('delete'); ?></button>
	</div>
	<?php endif; ?>
  </li>
  <?php endforeach; p('ctr_photos', $ids); ?>
</ul>
<div class="clearfix"></div>
