<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="grid mx-auto playlists">
  <?php foreach ($this->objects as $object): $playlist_id = $object['object_id']; $playlist = unserialize($object['object_data']); $name = e($playlist['name']); ?>
  <div id="playlist-<?php echo $photo_id; ?>" class="cell playlist">
	<div class="playlist-thumb">
	  <a href="<?php echo REL_URL.LANG.'/playlist/',$playlist_id,'/',e($playlist['slug']); ?>/" title="<?php echo $name; ?>">
		<img src="<?php echo THUMB_URL,'/',path($playlist['thumb_id']),'/',$playlist['thumb']; ?>.jpg" alt="<?php echo __('playlist-thumb', $name); ?>">
		<div class="playlist-info playlist-videos"><i class="fa fa-video-camera"></i> <?php echo $playlist['total_videos']; ?></div>
		<?php if (isset($playlist['total_views'])): ?>
        <div class="playlist-info playlist-views"><i class="fa fa-eye"></i> <?php echo VText::formatNum($playlist['total_views']); ?></div>
        <?php endif; ?>
	  </a>
	</div>
	<h5 class="playlist-title"><a href="<?php echo REL_URL.LANG.'/playlist/',$playlist_id,'/',e($playlist['slug']); ?>/" title="<?php echo $name; ?>"><?php echo $name; ?></a></h5>
  </div>
  <?php endforeach; ?>
</div>