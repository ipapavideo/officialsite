<?php defined('_VALID') or die('Restricted Access!'); $vast = p('adv_vast', true); ?>
<script src="<?php echo REL_URL; ?>/misc/plyr/plyr.min.js"></script>
<?php if ($this->hls): ?>
<script src="<?php echo REL_URL; ?>/misc/hls-js/hls.min.js"></script>
<?php endif; ?>
<script>
$(document).ready(function() {
  var width = $('#player-container-fluid').width();
  var height = width/1.777777778;
  $("#player-container-fluid").height(height);
  $("#player-fluid").show();
  
  <?php if ($this->hls): ?>
  const video = document.querySelector('video');
  if (Hls.isSupported()) {
	const hls = new Hls();
	hls.loadSource('<?php echo VHelper_video_hls::get($this->video_id, $this->video['server_id'], 'playlist.m3u8'); ?>');
	hls.attachMedia(video);
	window.hls = hls;
  } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
	video.src = '<?php echo VHelper_video_hls::get($this->video_id, $this->video['server_id'], 'playlist.m3u8'); ?>';
	video.addEventListener('loadedmetadata',function() {video.play();});
  }
  <?php endif; ?>
  
  const player = new Plyr('#player-fluid', {
  'preload': "'auto'",
  'poster': '<?php echo THUMB_URL,'/',path($this->video_id); ?>/player.jpg',
	<?php if (VCfg::get('video.thumb_sprite')): ?>
	'previewThumbnails': {enabled: true, src: '<?php echo THUMB_URL,'/',path($this->video_id); ?>/sprite.vtt'},
	<?php endif; if ($vast): ?>
	'ads': {enabled: true, tagUrl: '<?php echo $vast['1']['vast_url']; ?>'}
	<?php endif; ?>
  });
  
  player.on('pause', function() {$('#player-advertising').show();});
  player.on('play', function() {$('#player-advertising').hide();});
  $('#player-close').on('click', function(e) {e.preventDefault(); player.play();});  
});
</script>
