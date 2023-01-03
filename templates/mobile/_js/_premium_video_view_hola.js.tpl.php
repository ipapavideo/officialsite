<?php defined('_VALID') or die('Restricted Access!'); VHelper::load('module.video.stream'); $hls = (VPlugin::valid('hls') and $this->video['hls']) ? true : false; if ($hls): VHelper::load('module.video.hls'); endif; ?>
<script src="<?php echo REL_URL; ?>/misc/hola_player/hola_player.js"></script>
<script>
(function() {
  window.hola_player({
	'player': '#player',
	'swf': '<?php echo BASE_URL; ?>/misc/hola_player/videojs.swf',
	'osmf_swf': '<?php echo BASE_URL; ?>/misc/hola_player/videojs-osmf.swf',
	'controls': <?php echo (VCfg::get('player.videojs.controls')) ? 'true' : 'false'; ?>,
	'autoplay': <?php echo (VCfg::get('player.videojs.autoplay')) ? 'true' : 'false'; ?>,
	'preload': <?php echo (VCfg::get('player.videojs.preload')) ? "'auto'" : 'false'; ?>,
	'poster': '<?php echo THUMB_URL,'/',path($this->video_id); ?>/player.jpg',
	<?php if (VCfg::get('player.videojs.speed')): ?>'playbackRates': [0.5, 0.7, 1.0, 1.5, 2.0],<?php endif; ?>
	'sources': [
	<?php if ($hls): ?>{'src':'<?php echo VHelper_video_hls::get($this->video_id, $this->video['server_id'], 'playlist.m3u8', null, true, $this->trailer); ?>', 'type':'application/x-mpegurl'},<?php endif; ?>
	<?php foreach ($this->files as $index => $file): $url = ($file['url'] != '') ? $file['url'] : VHelper_video_stream::get_urle($this->video_id, $file['file_id'], $file['postfix'], $file['ext'], $this->video['server_id'], true, $this->trailer); ?>
	{'src':'<?php echo $url; ?>', 'type':'video/mp4', 'label':'<?php echo $file['resolution']; ?>'}<?php if (isset($this->files[$index+1])): echo ', '; endif; ?>
	<?php endforeach; ?>
	],
	'thumbnails': {'vtt': '<?php echo THUMB_URL,'/',path($this->video_id); ?>/sprite.vtt'}
	<?php if ($logo = VCfg::get('player.hola.logo_url')): ?>
	,'watermark': {'image': '<?php echo $logo; ?>', 'position': '<?php echo VCfg::get('player.hola.position'); ?>', 'url': '<?php echo CUR_URL; ?>', 'fadeTime': 0}
	<?php endif; if ($clogo = VCfg::get('player.hola.clogo_url')): ?>
    ,'controls_watermark': {'image': '<?php echo $clogo; ?>', 'tooltip': '<?php echo e($this->video['title']); ?>', 'url': '<?php echo CUR_URL; ?>',
	<?php endif; ?>
  });
})();
</script>
