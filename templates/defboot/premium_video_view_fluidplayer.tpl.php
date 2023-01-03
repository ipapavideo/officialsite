<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_premium_video_view_fluidplayer.js'; VHelper::load('module.video.stream'); $hls = (VPlugin::valid('hls') and $this->video['hls']) ? true : false; if ($hls): VHelper::load('module.video.hls'); endif; $mobile = VF::factory('device')->isMobile(); ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/fluidplayer/fluidplayer.min.css">
<div id="player-container-fluid">
  <?php if ($this->trailer): ?>
  <div id="player-premium">
    <?php echo __('premium-trailer'); ?><br>
    <?php if ($this->premium == 'login'): echo __('trailer-login', array('<a href="'.REL_URL.'/user/login/" class="login btn btn-link"><strong>','</strong> <i class="fa fa-sign-in"></i></a>','<a href="'.REL_URL.'/premium/register/" class="btn btn-link"><strong>','</strong> <i class="fa fa-user-plus"></i></a>'));
    elseif ($this->premium == 'upgrade'): echo __('trailer-upgrade', array('<a href="'.REL_URL.'/premium/upgrade/" class="btn btn-link"><strong>','</strong> <i class="fa fa-level-up-alt"></i></a>'));
    elseif ($this->premium == 'credit'): echo __('trailer-credit', array('<a href="'.REL_URL.'/premium/credit/" class="btn btn-link"><strong>', '</strong> <i class="fa fa-credit-card</a>'));
    elseif ($this->premium == 'renew'): echo __('player-renew', array('<a href="'.REL_URL.'/premium/renew/" class="btn btn-link"><strong>', '</strong> <i class="fa fa-sync"></i></a>')); endif; ?>
    </div>
  <?php endif; ?>
  <video id="player-fluid" controls>
    <?php if ($hls and $mobile): ?><source src="<?php echo VHelper_video_hls::get($this->video_id, $this->video['server_id'], 'playlist.m3u8'); ?>" type="application/x-mpegURL" /><?php else: ?>
    <?php foreach ($this->files as $index => $file): $url = ($file['url'] != '') ? $file['url'] : VHelper_video_stream::get_urle($this->video_id, $file['file_id'], $file['postfix'],  $file['ext'], $this->video['server_id'], true, $file['trailer']); ?>
    <source src="<?php echo urldecode($url); ?>" type="video/mp4" title="<?php echo $file['resolution']; ?>" />
    <?php endforeach; endif; ?>
    <p class="text-center">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video!</a></p>
  </video>
</div>

