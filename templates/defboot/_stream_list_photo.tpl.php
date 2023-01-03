<?php defined('_VALID') or die('Restricted Access!'); $upload = (VCfg::get('photo.upload')) ? true : false; ?>
<ul class="photos photoss">
  <?php $loggedin = VAuth::loggedin(); $id = (isset($this->id)) ? '-'.$this->id : ''; $ids = array();
  foreach ($this->objects as $object): $photo_id = $object['object_id']; $photo = unserialize($object['object_data']); $ids[] = $photo_id;
  $percent  = ($photo['percent']) ? round($photo['percent']) : 100;
  $class    = ($percent >= 50) ? 'up' : 'down'; ?>
  <li id="photo-<?php echo $photo_id; ?>" class="photo">
    <a href="<?php echo REL_URL,LANG,'/photo/',$photo_id; ?>/" title="<?php echo e($photo['caption']); ?>" class="image">
      <div class="photo-thumb">
        <img src="<?php echo PHOTO_THUMB_URL,'/',$photo_id; ?>.jpg" alt="<?php echo __('photo-thumb', $photo['caption']); ?>">
        <?php if ($photo['type'] == '1'): ?>
        <div class="private-overlay"><i class="fa fa-lock fa-5x"></i></div>
        <?php endif; ?>
      </div>
    </a>
    <span class="views"><?php echo $photo['total_views'],' '; if ($photo['total_views'] == '1'): echo __('view'); else: echo __('views'); endif; ?></span>
    <span class="rating <?php echo $class; ?>"><i class="fa fa-thumbs-<?php echo $class; ?>"></i> <?php echo $percent; ?>%</span>
  </li>
  <?php endforeach; p('ctr_photos', $ids); ?>
</ul>
<div class="clearfix"></div>
