<?php defined('_VALID') or die('Restricted Access!'); ?>
<ul class="videos videoss">
  <?php $loggedin = VAuth::loggedin(); $playlists = VModule::enabled('playlist'); $id = (isset($this->id)) ? '-'.$this->id : '';
  $video_preview = VCfg::get('video.thumb_video') ? ' video-preview' : ''; $thumb_preview = (!$video_preview && VCfg::get('video.thumb_preview')) ? ' thumb-preview' : '';
  $ids = array(); foreach ($this->objects as $object): $video_id = $object['object_id']; $video = unserialize($object['object_data']);
  $percent	= ($video['percent']) ? round($video['percent']) : 100;
  $private  = ($video['type'] == '1') ? ' video-private' : false;
  $preview  = ($private) ? ' video-private' : $video_preview.$thumb_preview;  
  $class	= ($percent >= 50) ? 'up' : 'down';
  $data		= ' data-id="'.$video_id.'" data-thumb="'.$video['thumb'].'" data-thumbs="'.$video['thumbs'].'"'; ?>
  <li id="video-<?php echo $video_id; ?>" class="video<?php if ($private): echo ' video-private'; endif; ?>">
	<a href="<?php echo video_view_url($video_id, $video['slug']); ?>" title="<?php echo e($video['title']); ?>" class="image">
	  <div class="video-thumb<?php echo $video_preview,$thumb_preview; ?>">
		<img src="<?php echo THUMB_URL,'/',path($video_id),'/',$video['thumb']; ?>.jpg" alt="<?php echo e($video['title']); ?>" id="preview-<?php echo $video_id,$id; ?>"<?php echo $data; ?>>
		<span class="duration"><?php if ($video['hd']): echo '<strong>HD</strong> '; endif; echo VDate::duration($video['duration']); ?></span>
        <?php if ($private): ?>
        <div class="private-overlay"><i class="fa fa-lock fa-2x"></i><br><?php echo __('private'); ?></div>
        <?php endif; ?>		
	  </div>
	</a>
	<span class="title"><a href="<?php echo video_view_url($video_id, $video['slug']); ?>" title="<?php echo e($video['title']); ?>"><?php echo e($video['title']); ?></a></span>
	<span class="views"><?php echo $video['total_views'],' '; if ($video['total_views'] == '1'): echo __('view'); else: echo __('views'); endif; ?></span>
	<span class="rating <?php echo $class; ?>"><i class="fa fa-thumbs-<?php echo $class; ?>"></i> <?php echo $percent; ?>%</span>
	<?php if ($loggedin and $playlists): ?>
	<button class="btn btn-icon btn-xs btn-playlist" data-id="<?php echo $video_id; ?>" type="button" data-toggle="dropdown" aria-expanded="false" style="display: none;"><i class="fa fa-plus"></i></button>
	<?php endif; ?>
  </li>
  <?php endforeach; p('ctr_videos', $ids); ?>
</ul>
<div class="clearfix"></div>
