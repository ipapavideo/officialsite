<?php defined('_VALID') or die('Restricted Access!'); ?>
<ul class="playlists playlistss">
  <?php foreach ($this->objects as $object): $playlist_id = $object['object_id']; $playlist = unserialize($object['object_data']); ?>
  <li id="playlist-<?php echo $playlist['playlist_id']; ?>" class="playlist">
	<div class="playlist-container">
  	  <a href="<?php echo REL_URL.LANG.'/playlist/',$playlist['playlist_id'],'/',e($playlist['slug']); ?>/" title="<?php echo e($playlist['name']); ?>" class="image">
  		<div class="playlist-thumb">
  		  <img src="<?php echo THUMB_URL,'/',path($playlist['thumb_id']),'/',$playlist['thumb']; ?>.jpg" alt="<?php echo __('playlist-thumb', e($playlist['name'])); ?>">
  		  <div class="playlist-videos"><i class="fa fa-video-camera"></i> <?php echo $playlist['total_videos']; ?></div>
  		</div>
  	  </a>
  	  <div class="playlist-overlay">
  		<a href="<?php echo REL_URL.LANG.'/playlist/',$playlist['playlist_id'],'/',e($playlist['slug']); ?>/" class="playlist-view"><i class="fa fa-th-list"></i> <?php echo __('view-playlist'); ?></a>
  		<a href="<?php echo video_view_url($playlist['thumb_id'], $playlist['video_slug'], 'playlist='.$playlist['playlist_id']); ?>" class="playlist-play"><i class="fa fa-play"></i> <?php echo __('play-all'); ?></a>
  	  </div>
  	</div>
    <span class="playlist-title"><a href="<?php echo REL_URL.LANG.'/playlist/',$playlist['playlist_id'],'/',e($playlist['slug']); ?>/" title="<?php echo e($playlist['name']); ?>"><?php echo e($playlist['name']); ?></a></span>
  </li>
  <?php endforeach; ?>
</ul>
<div class="clearfix"></div>