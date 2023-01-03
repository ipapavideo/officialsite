<?php defined('_VALID') or die('Restricted Access!'); VHelper::load('module.video.stream'); $hls = (VPlugin::valid('hls') and $this->video['hls']) ? true : false; if ($hls): VHelper::load('module.video.hls'); endif; $mobile = VF::factory('device')->isMobile(); ?>
<script src="<?php echo REL_URL; ?>/misc/flowplayer/flowplayer.min.js"></script>
<?php if ($hls): ?>
<script src="<?php echo REL_URL; ?>/misc/flowplayer-hlsjs/flowplayer.hlsjs.light.min.js"></script>
<?php endif; if (VCfg::get('player.flowplayer.speed')): ?>
<script src="<?php echo REL_URL; ?>/misc/flowplayer-speedmenu/flowplayer.speed-menu.min.js"></script>
<?php endif; ?>
<script>
$(document).ready(function() {
  var container = document.getElementById("player");
  flowplayer(container, {
	controls: <?php echo (VCfg::get('player.flowplayer.controls')) ? 'true' : 'false'; ?>,
	autoplay: <?php echo (VCfg::get('player.flowplayer.autoplay')) ? 'true' : 'false'; ?>,
	preload: <?php echo (VCfg::get('player.flowplayer.preload')) ? "'auto'" : 'false'; ?>,
	poster: '<?php echo THUMB_URL,'/',path($this->video_id); ?>/player.jpg',
	<?php if ($key = VCfg::get('player.flowplayer.key')): ?>
	key: '<?php echo $key; ?>',
	<?php endif; if ($logo = VCfg::get('player.flowplayer.logo_url')): ?>
	logo: '<?php echo $logo; ?>',
	<?php endif; ?>
	share: false,
	clip: {
	  sources: [
		<?php if ($hls): ?>{type: 'application/x-mpegurl', src: '<?php echo VHelper_video_hls::get($this->video_id, $this->video['server_id'], 'playlist.m3u8'); ?>'},<?php endif; ?>
		<?php foreach ($this->files as $index => $file): $url = ($file['url'] != '') ? $file['url'] : VHelper_video_stream::get_urle($this->video_id, $file['file_id'], $file['postfix'],  $file['ext'], $this->video['server_id']); ?>
		{type: 'video/mp4', src: '<?php echo urldecode($url); ?>'}<?php if (isset($this->files[$index+1])): echo ', '; endif; ?>
		<?php endforeach; ?>
	  ]
	}
  });
});
</script>
