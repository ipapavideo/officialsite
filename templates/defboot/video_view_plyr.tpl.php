<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_view_plyr.js'; VHelper::load('module.video.stream'); $this->hls = (VPlugin::valid('hls') and $this->video['hls']) ? true : false; $mobile = VF::factory('device')->isMobile(); if ($this->hls and (VCfg::get('hls.hls_desktop') or $mobile)): VHelper::load('module.video.hls'); else: $this->hls = false; endif; ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/plyr/plyr.css">
<div id="player-container-fluid">
  <?php $adv = p('adv_overlay'); if ($adv): echo $adv; endif; ?>
  <video id="player-fluid" controls poster="<?php echo THUMB_URL,'/',path($this->video_id); ?>/player.jpg" />
	<?php if (!$this->hls): foreach ($this->files as $index => $file): $url = ($file['url'] != '') ? $file['url'] : VHelper_video_stream::get_urle($this->video_id, $file['file_id'], $file['postfix'],  $file['ext'], $this->video['server_id']); ?>
	<source src="<?php echo urldecode($url); ?>" type="video/mp4" size="<?php echo str_replace('p', '', $file['resolution']); ?>" />
	<?php endforeach; endif; ?>
  </video>
</div>
