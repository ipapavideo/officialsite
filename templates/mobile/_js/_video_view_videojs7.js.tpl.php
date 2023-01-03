<?php defined('_VALID') or die('Restricted Access!'); VHelper::load('module.video.stream'); $hls = (VPlugin::valid('hls') and $this->video['hls']) ? true : false; $mobile = VF::factory('device')->isMobile(); if ($hls and (VCfg::get('hls.hls_desktop') or $mobile)): VHelper::load('module.video.hls'); else: $hls = false; endif; $vast = p('adv_vast'); ?>
<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<?php if ($minify = VCfg::get('player.videojs.minify')): ?>
<script src="<?php echo REL_URL; ?>/misc/videojs7-all/video.min.js?t=<?php echo $minify; ?>"></script>
<?php else: ?>
<script src="<?php echo REL_URL; ?>/misc/videojs7/video.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-contrib-ads/videojs-contrib-ads.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-ima/videojs.ima.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-contrib-quality-levels/videojs-contrib-quality-levels.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-http-source-selector/videojs-http-source-selector.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-vtt-thumbnails/videojs-vtt-thumbnails.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-hotkeys/videojs.hotkeys.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-quality-selector/silvermine-videojs-quality-selector.min.js"></script>
<?php endif; ?>
<script type="text/javascript">
var ad_skip = 5;
$(document).ready(function() {
var player = videojs('player', {
  'controls': <?php echo (VCfg::get('player.videojs.controls')) ? 'true' : 'false'; ?>,
  'autoplay': <?php echo (VCfg::get('player.videojs.autoplay')) ? 'true' : 'false'; ?>,
  'preload': <?php echo (VCfg::get('player.videojs.preload')) ? "'auto'" : 'false'; ?>,
  'poster': '<?php echo THUMB_URL,'/',path($this->video_id); ?>/player.jpg',
  <?php if (VCfg::get('player.videojs.speed')): ?>'playbackRates': [0.5, 0.7, 1.0, 1.5, 2.0],<?php endif; ?>
  'sources': [
  <?php if ($hls): ?>{'src':'<?php echo VHelper_video_hls::get($this->video_id, $this->video['server_id'], 'playlist.m3u8'); ?>', 'type':'application/x-mpegurl', 'withCredentials': false},<?php endif; ?>
  <?php $files = array_reverse($this->files); foreach ($files as $index => $file): $url = ($file['url'] != '') ? $file['url'] : VHelper_video_stream::get_urle($this->video_id, $file['file_id'], $file['postfix'], $file['ext'], $this->video['server_id']); $selected = ($file['resolution'] == '360p') ? ", 'selected':true" : ''; ?>
  {'src':'<?php echo urldecode($url); ?>', 'type':'video/mp4', 'label':'<?php echo $file['resolution']; ?>', 'res':'<?php echo str_replace('p', '', $file['resolution']); ?>'<?php echo $selected; ?>}<?php if (isset($this->files[$index+1])): echo ', '; endif; ?>
  <?php endforeach; ?>]<?php if ($this->video['hotlinked'] == '0'): ?>,
  'tracks': [{'kind':'metadata', 'src':'<?php echo THUMB_URL,'/',path($this->video_id); ?>/sprite.vtt'}]
  <?php endif; ?>
});
player.on('contextmenu', function(e) {e.preventDefault();});
player.on('pause', function() {$('#player-advertising').show();});
player.on('play', function() {$('#player-advertising').hide();});
<?php if ($hls): ?>
player.httpSourceSelector({'default':'auto'});
<?php else: ?>
player.controlBar.el().insertBefore(player.controlBar.addChild('QualitySelector').el(), player.controlBar.getChild('fullscreenToggle').el());
<?php endif; ?>
player.on('loadedmetadata', function(){player.vttThumbnails({'src': '<?php echo BASE_URL,'/media/videos/tmb/',path($this->video_id); ?>/sprite.vtt'});});
<?php if (VCfg::get('player.videojs.watermark') && $logo = VCfg::get('player.videojs.logo_url')): ?>
player.watermark({
  'file': '<?php echo $logo; ?>',
  'url': '<?php echo CUR_URL; ?>',
  <?php $position = VCfg::get('player.videojs.position'); if ($position == 'top-left'): ?>
  'xpos': 0, 'ypos': 0
  <?php elseif ($position == 'bottom-right'): ?>
  'xpos': 100, 'ypos': 100
  <?php elseif ($position == 'bottom-left'): ?>
  'xpos': 0, 'ypos': 100
  <?php else: ?>
  'xpos': 100, 'ypos': 0
  <?php endif; ?>
});
<?php endif; if (isset($this->url_next)): ?>
player.ready(function() {this.on('ended', function() {window.location = '<?php echo $this->url_next; ?>';});});
<?php endif; if ($vast): if ($vast['vast_text']): $vast = "'adsResponse': '".str_replace("\n", '', $vast['vast_text'])."'"; else: $vast = "'adTagUrl': '".$vast['vast_url']."'"; endif; ?>
player.ima({'id': 'player',<?php echo $vast; ?>});
<?php endif; ?>
$('#player-close').on('click', function(e) {e.preventDefault(); player.play();});
});
</script>
