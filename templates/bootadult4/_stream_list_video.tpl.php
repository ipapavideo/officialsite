<?php defined('_VALID') or die('Restricted Access!');
$lazy			= VCfg::get('template.bootadult4.lazy');
$id				= '-stream-'.VText::uniq();
$hd             = __('hd');
$loggedin       = VAuth::loggedin();
$user_id		= ($loggedin) ? (int) VSession::get('user_id') : 0;
$playlist       = VModule::enabled('playlist');
$video_preview  = VCfg::get('video.thumb_video') ? ' video-preview' : '';
$thumb_preview  = (!$video_preview && VCfg::get('video.thumb_preview')) ? ' thumb-preview' : '';
$ids            = array(); ?>
<div class="grid mx-auto videos">
  <?php foreach ($this->objects as $object): $video_id = $object['object_id']; $video = unserialize($object['object_data']);
        $percent    = ($video['percent']) ? round($video['percent']) : 100;
        $class      = ($percent >= 50) ? 'up' : 'down';
        $class_text = ($class == 'up') ? ' text-success' : ' text-danger';
        $private    = (isset($video['type']) and $video['type'] == '1') ? true : false;
        $premium    = (isset($video['premium']) and $video['premium']) ? true : false;
        $preview    = (isset($video['thumb_url']) and $video['thumb_url']) ? '' : $video_preview.$thumb_preview;;
        $cache      = (isset($video['thumb_time']) and $video['thumb_time']) ? '?t='.$video['thumb_time'] : '';
        $thumb      = (isset($video['thumb_url']) and $video['thumb_url']) ? $video['thumb_url'] : THUMB_URL.'/'.path($video_id).'/'.$video['thumb'].'.jpg'.$cache;
        $thumb      = (isset($video['type']) and $video['type'] == '1') ? THUMB_URL.'/private.jpg' : $thumb;
        $data_src   = ($lazy and !$private) ? ' data-src="'.$thumb.'"' : '';
        $thumb      = ($lazy and !$private) ? THUMB_URL.'/loading.jpg' : $thumb;
        $lazyc      = ($lazy and !$private) ? ' lazy' : '';
        $data       = ' data-id="'.$video_id.'" data-thumb="'.$video['thumb'].'" data-thumbs="'.$video['thumbs'].'"';
        $title      = e($video['title']);
        $premium	= (isset($video['premium']) and $video['premium']) ? true : false;
        $url        = video_view_url($video_id, $video['slug'], null, $premium, false); ?>
  <div id="video-<?php echo $video_id; ?>" class="cell video">
	<div class="video-thumb<?php echo $preview; ?>">
	  <a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
		<img src="<?php echo $thumb; ?>"<?php echo $data_src; ?> class="thumb<?php echo $lazyc; ?>" alt="<?php echo $title; ?>" id="preview-<?php echo $video_id.$id.'"'.$data; ?>>
	  </a>
	  <?php if ($loggedin): ?>
	  <div class="video-actions">
		<?php if ($playlist): ?>
		<a href="#add-to-playlist" class="d-inline video-playlist"><i class="fa fa-plus"></i></a>
		<?php endif; if (isset($video['user_id']) and $user_id != $video['user_id']): ?>
		<a href="#add-to-favorites" class="d-inline video-favorite" data-id="<?php echo $video_id; ?>"><i class="fa fa-heart"></i></a>
		<?php endif; ?>
	  </div>
	  <?php endif; ?>
	  <div class="video-info video-rating '.$class.'"><i class="fa fa-thumbs-<?php echo $class.$class_text; ?>"></i> <?php echo $percent; ?>%</div>
	  <div class="video-info video-duration"><i class="fa fa-clock-o"></i> <?php echo VDate::duration($video['duration']); ?></div>
	  <div class="video-info video-views"><i class="fa fa-eye"></i> <?php echo VText::formatNum($video['total_views']); ?></div>
	</div>
	<div class="video-caption">
	  <h5 class="video-title"><a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h5>
	</div>
  </div>
  <?php endforeach; ?>
</div>