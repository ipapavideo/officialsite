<?php defined('_VALID') or die('Restricted Access!'); ?>
<ul class="playlists<?php if (isset($this->pclass)): echo ' ',$this->pclass; endif; ?>">
  <?php foreach ($this->playlists as $playlist): $cache = ($playlist['thumb_time']) ? '?t='.$playlist['thumb_time'] : ''; $thumb = ($playlist['thumb_url']) ? $playlist['thumb_url'] : THUMB_URL.'/'.path($playlist['thumb_id']).'/'.$playlist['thumb'].'.jpg'.$cache; ?>
  <li id="playlist-<?php echo $playlist['playlist_id']; ?>" class="playlist">
	<div class="playlist-container">
  	  <a href="<?php echo REL_URL.LANG.'/playlist/',$playlist['playlist_id'],'/',e($playlist['slug']); ?>/" title="<?php echo e($playlist['name']); ?>" class="image">
  		<div class="playlist-thumb">
  		  <img src="<?php echo $thumb; ?>" alt="<?php echo __('playlist-thumb', e($playlist['name'])); ?>">
  		  <div class="playlist-videos"><i class="fa fa-video-camera"></i> <?php echo $playlist['total_videos']; ?></div>
  		</div>
  	  </a>
  	  <div class="playlist-overlay">
  		<a href="<?php echo REL_URL.LANG.'/playlist/',$playlist['playlist_id'],'/',e($playlist['slug']); ?>/" class="playlist-view"><i class="fa fa-th-list"></i> <?php echo __('view-playlist'); ?></a>
  		<a href="<?php echo video_view_url($playlist['thumb_id'], $playlist['video_slug'], 'playlist='.$playlist['playlist_id']); ?>" class="playlist-play"><i class="fa fa-play"></i> <?php echo __('play-all'); ?></a>
  	  </div>
  	</div>
    <span class="playlist-title"><a href="<?php echo REL_URL.LANG.'/playlist/',$playlist['playlist_id'],'/',e($playlist['slug']); ?>/" title="<?php echo e($playlist['name']); ?>"><?php echo e($playlist['name']); ?></a></span>
    <?php if (isset($this->colmenu)): ?>
    <div class="actions">
      <a href="<?php echo REL_URL,LANG,'/playlist/edit/',$playlist['playlist_id']; ?>/" class="btn btn-ns btn-warning"><?php echo __('edit'); ?></a>
      <button class="btn-remove btn btn-ns btn-danger" data-id="<?php echo $playlist['playlist_id']; ?>"><?php echo __('delete'); ?></button>
    </div>
    <?php endif; ?>
  </li>
  <?php endforeach; ?>
</ul>
<div class="clearfix"></div>