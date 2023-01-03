<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_view_fluidplayer.js'; VHelper::load('module.video.stream'); $hls = (VPlugin::valid('hls') and $this->video['hls']) ? true : false; $mobile = VF::factory('device')->isMobile(); if ($hls and (VCfg::get('hls.hls_desktop') or $mobile)): VHelper::load('module.video.hls'); else: $hls = false; endif; ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/fluidplayer/fluidplayer.min.css">
<div id="player-container-fluid">
  <?php $adv = p('adv_overlay'); if ($adv): echo $adv; endif; ?>
  <video id="player-fluid" controls>
	<?php if ($hls): if (VCfg::get('hls.hls_auto')): ?>
	<source src="<?php echo VHelper_video_hls::get($this->video_id, $this->video['server_id'], 'playlist.m3u8'); ?>" type="application/x-mpegURL" />
	<?php else: foreach ($this->files as $index => $file): ?>
	<source src="<?php echo VHelper_video_hls::get($this->video_id, $this->video['server_id'], $file['resolution']); ?>.m3u8" type="application/x-mpegURL" title="<?php echo $file['resolution']; ?>" />	
	<?php endforeach; endif; else: foreach ($this->files as $index => $file): $url = ($file['url'] != '') ? $file['url'] : VHelper_video_stream::get_urle($this->video_id, $file['file_id'], $file['postfix'],  $file['ext'], $this->video['server_id']); ?>
	<source src="<?php echo urldecode($url); ?>" type="video/mp4" title="<?php echo $file['resolution']; ?>" />
	<?php endforeach; endif; ?>
    <p class="text-center">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video!</a></p>
  </video>
</div>
