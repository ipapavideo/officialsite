<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_view_videojs7.js'; ?>
<?php if ($minify = VCfg::get('player.videojs7.minify')): ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs7-all/video.min.css?t=<?php echo $minify; ?>">
<?php else: ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs7/video-js.min.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-contrib-ads/videojs-contrib-ads.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-ima/videojs.ima.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-vtt-thumbnails/videojs-vtt-thumbnails.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-quality-selector/quality-selector.css">
<?php endif; ?>
<div id="player-container">
  <?php $adv = p('adv_overlay'); if ($adv): echo $adv; endif; ?>  
  <video id="player" class="video-js vjs-big-play-centered">
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video!</a></p>
  </video>
</div>
