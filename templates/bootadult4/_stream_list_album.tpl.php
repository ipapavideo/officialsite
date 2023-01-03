<?php defined('_VALID') or die('Restricted Access!'); $loggedin = VAuth::loggedin(); $ids = array(); ?>
<div class="grid mx-auto albums">
  <?php foreach ($this->objects as $object): $album_id = $object['object_id']; $album = unserialize($object['object_data']); 
  $ids[]      = $album_id;
  $percent    = ($album['percent']) ? round($album['percent']) : 100;
  $class      = ($percent >= 50) ? 'up' : 'down';
  $class_text = ($class == 'up') ? ' text-success' : ' text-danger';
  $private    = (isset($album['type']) and $album['type'] == '1') ? true : false;
  $premium    = (isset($album['premium']) and $album['premium']) ? true : false;
  $title      = e($album['title']);
  $url        = album_url($album_id, $album['slug'], $premium, false); ?>
  <div id="album-<?php echo $album_id; ?>" class="cell album">
	<div class="album-thumb">
	  <a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><img src="<?php echo PHOTO_THUMB_URL.'/'.$album['cover_id']; ?>.jpg" class="thumb" alt="<?php echo __('album-cover', $album['title']); ?>"></a>
	  <div class="album-info album-rating '.$class.'"><i class="fa fa-thumbs-<?php echo $class.$class_text; ?>"></i> <?php echo $percent; ?>%</div>
	  <div class="album-info album-photos"><i class="fa fa-camera"></i> <?php echo $album['total_photos']; ?></div>
	  <div class="album-info album-views"><i class="fa fa-eye"></i> <?php echo VText::formatNum($album['total_views']); ?></div>
	</div>
	<h5 class="w-100 text-center"><a href="<?php echo $url; ?>" title="<?php echo $title; ?>" rel="nofollow"><?php echo $title; ?></a></h5>
  </div>
  <?php endforeach; ?>
</div>