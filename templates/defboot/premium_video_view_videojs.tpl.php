<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_premium_video_view_videojs.js'; ?>
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
<?php endif; endif; ?>
<div id="player-container">
  <?php if ($this->trailer): ?>
  <div id="player-premium">
	<?php echo __('premium-trailer'); ?><br>
	<?php if ($this->premium == 'login'): echo __('trailer-login', array('<a href="'.REL_URL.'/user/login/" class="login btn btn-link"><strong>','</strong> <i class="fa fa-sign-in"></i></a>','<a href="'.REL_URL.'/premium/register/" class="btn btn-link"><strong>','</strong> <i class="fa fa-user-plus"></i></a>'));
	elseif ($this->premium == 'upgrade'): echo __('trailer-upgrade', array('<a href="'.REL_URL.'/premium/upgrade/" class="btn btn-link"><strong>','</strong> <i class="fa fa-level-up-alt"></i></a>'));
	elseif ($this->premium == 'credit'): echo __('trailer-credit', array('<a href="'.REL_URL.'/premium/credit/" class="btn btn-link"><strong>', '</strong> <i class="fa fa-credit-card</a>'));
	elseif ($this->premium == 'renew'): echo __('player-renew', array('<a href="'.REL_URL.'/premium/renew/" class="btn btn-link"><strong>', '</strong> <i class="fa fa-sync"></i></a>')); endif; ?>
  </div>
  <?php endif; ?>
  <video id="player" class="video-js vjs-default-skin vjs-big-play-centered">
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video!</a></p>
  </video>
</div>
