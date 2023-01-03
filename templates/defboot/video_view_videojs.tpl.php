<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_view_videojs.js'; $this->vast = p('adv_vast'); $this->preroll = false; if (!$this->vast): $this->preroll = p('adv_preroll'); endif; ?>
<?php if ($minify = VCfg::get('player.videojs.minify')): ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-all/video.min.css?t=<?php echo $minify; ?>">
<?php if ($this->vast): ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-ima/videojs.ima.css">
<?php endif; else: ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs/video-js.min.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-skin/videojs.skin.css">
<?php if (VCfg::get('player.videojs.resolution')): ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-resolution-switcher-hls/videojs-resolution-switcher.css">
<?php endif; if (VCfg::get('player.videojs.watermark')): ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-watermark/videojs.watermark.css">
<?php endif; if (VCfg::get('player.videojs.thumbnails')): ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-thumbnails/videojs.thumbnails.css">
<?php endif; if ($this->vast): ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-ads/videojs.ads.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-ima/videojs.ima.css">
<?php endif; if ($this->preroll): ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-ads/videojs.ads.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/videojs-preroll/videojs-preroll.css">
<?php endif; endif; ?>
<div id="player-container">
  <?php $adv = p('adv_overlay'); if ($adv): echo $adv; endif; ?>  
  <video id="player" class="video-js vjs-default-skin vjs-big-play-centered">
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video!</a></p>
  </video>
</div>
