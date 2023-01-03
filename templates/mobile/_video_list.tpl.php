<?php defined('_VALID') or die('Restricted Access!'); $hd = __('hd'); ?>
<ul class="videos<?php if (isset($this->vclass)): echo ' '.$this->vclass; endif; ?>">
  <?php $loggedin = VAuth::loggedin(); $playlists = VModule::enabled('playlist'); $id = (isset($this->id)) ? '-'.$this->id : '';
  $video_preview = VCfg::get('video.thumb_video') ? ' video-preview' : ''; $thumb_preview = (!$video_preview && VCfg::get('video.thumb_preview')) ? ' thumb-preview' : '';
  $ids = array(); foreach ($this->videos as $video): $ids[] = $video['video_id'];
  $percent	= ($video['percent']) ? round($video['percent']) : 100;
  $class	= ($percent >= 50) ? 'up' : 'down';
  $premium	= (isset($video['premium']) and $video['premium']) ? true : false;
  $private	= ($video['type'] == '1') ? ' video-private' : false;
  $preview	= ($private) ? ' video-private' : $video_preview.$thumb_preview;
  $preview  = ($video['thumb_url']) ? '' : $preview;
  $cache    = ($video['thumb_time']) ? '?t='.$video['thumb_time'] : '';
  $thumb    = ($video['thumb_url']) ? $video['thumb_url'] : THUMB_URL.'/'.path($video['video_id']).'/'.$video['thumb'].'.jpg'.$cache;
  $data		= ' data-id="'.$video['video_id'].'" data-thumb="'.$video['thumb'].'" data-thumbs="'.$video['thumbs'].'"'; ?>
  <li id="video-<?php echo $video['video_id'],$id; ?>" class="video<?php if ($private): echo ' video-private'; endif; ?>">
	<a href="<?php echo video_view_url($video['video_id'], $video['slug']); ?>" title="<?php echo e($video['title']); ?>" class="image">
	  <div class="video-thumb<?php echo $preview; ?>">
		<img src="<?php echo $thumb; ?>" alt="<?php echo e($video['title']); ?>" id="preview-<?php echo $video['video_id'],$id; ?>"<?php echo $data; ?>>
		<span class="duration"><?php if ($video['hd']): echo '<strong>'.$hd.'</strong> '; endif; echo VDate::duration($video['duration']); ?></span>
		<?php if ($private): ?>
		<div class="private-overlay"><i class="fa fa-lock fa-2x"></i><br><?php echo __('private'); ?></div>
		<?php endif; ?>
	  </div>
	</a>
	<span class="title"><a href="<?php echo video_view_url($video['video_id'], $video['slug']); ?>" title="<?php echo e($video['title']); ?>"><?php echo e($video['title']); ?></a></span>
	<span class="views"><?php echo $video['total_views'],' '; if ($video['total_views'] == '1'): echo __('view'); else: echo __('views'); endif; ?></span>
	<span class="rating <?php echo $class; ?>"><i class="fa fa-thumbs-<?php echo $class; ?>"></i> <?php echo $percent; ?>%</span>
	<?php if ($loggedin and $playlists): ?>
	<button class="btn btn-icon btn-xs btn-playlist" data-id="<?php echo $video['video_id']; ?>" type="button" data-toggle="dropdown" aria-expanded="false" style="display: none;"><i class="fa fa-plus"></i></button>
	<?php endif; if (isset($this->colmenu)): ?>
	<div class="actions">
	  <?php if ($this->submenu == 'user-videos'): ?>
	  <a href="<?php echo video_url(),'/edit/',$video['video_id']; ?>/" class="btn btn-ns btn-warning"><?php echo __('edit'); ?></a>
	  <?php endif; ?>
	  <button class="btn-remove btn btn-ns btn-danger" data-id="<?php echo $video['video_id']; ?>" data-sub="<?php echo e($this->submenu); ?>"><?php echo __('delete'); ?></button>
	</div>
	<?php endif; ?>
  </li>
  <?php endforeach; p('ctr_videos', $ids); ?>
</ul>
<div class="clearfix"></div>
