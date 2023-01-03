<?php defined('_VALID') or die('Restricted Access!'); $loggedin = VAuth::loggedin(); ?>
<div class="grid mx-auto photos">
  <?php foreach ($this->objects as $object): $photo_id = $object['object_id']; $photo = unserialize($object['object_data']); $ids[] = $photo_id;
  $percent    = ($photo['percent']) ? round($photo['percent']) : 100;
        $class      = ($percent >= 50) ? 'up' : 'down';
        $class_text = ($class == 'up') ? ' text-success' : ' text-danger';
        $private    = ($photo['type'] == '1') ? true : false;
        $premium    = (isset($photo['premium']) and $photo['premium']) ? true : false;
        $caption    = ($photo['caption']) ? $photo['caption'] : '';
        $url        = REL_URL.LANG.'/photo/'.$photo_id.'/';
        $user_id    = (isset($photo['user_id']) and $photo['user_id']) ? $photo['user_id'] : $album_user_id; ?>
  <div id="photo-<?php echo $photo_id; ?>" class="cell photo">
	<div class="photo-thumb">
	  <a href="<?php echo $url; ?>" title="<?php echo $caption; ?>"><img src="<?php echo PHOTO_THUMB_URL.'/'.$photo_id; ?>.jpg" class="thumb" alt="<?php echo __('photo-thumb', $caption); ?>"></a>
	  <div class="photo-info photo-rating <?php echo $class; ?>"><i class="fa fa-thumbs-<?php echo $class.$class_text; ?>"></i> <?php echo $percent; ?>%</div>
	  <div class="photo-info photo-views"><i class="fa fa-eye"></i> <?php echo VText::formatNum($photo['total_views']); ?></div>
	</div>
  </div>
  <?php endforeach; ?>
</div>