<?php defined('_VALID') or die('Restricted Access!'); VHelper::load('module.video.stream'); $hls = (VPlugin::valid('hls') and $this->video['hls']) ? true : false; if ($hls): VHelper::load('module.video.hls'); endif; $mobile = VF::factory('device')->isMobile(); ?>
<?php if ($minify = VCfg::get('player.videojs.minify')): ?>
<script src="<?php echo REL_URL; ?>/misc/videojs-all/video.min.js?t=<?php echo $minify; ?>"></script>
<?php if ($hls): ?>
<script src="<?php echo REL_URL; ?>/misc/videojs-contrib-hls/videojs-contrib-hls.min.js"></script>
<?php endif; if ($this->vast): ?>
<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-ima/videojs.ima.min.js"></script>
<?php endif; else: ?>
<script src="<?php echo REL_URL; ?>/misc/videojs/video.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs/ie8/videojs-ie8.min.js"></script>
<?php if ($hls): ?>
<script src="<?php echo REL_URL; ?>/misc/videojs-contrib-hls/videojs-contrib-hls.min.js"></script>
<?php endif; if (VCfg::get('player.videojs.resolution')): ?>
<script src="<?php echo REL_URL; ?>/misc/videojs-resolution-switcher-hls/videojs-resolution-switcher.js"></script>
<?php endif; if (VCfg::get('player.videojs.hotkeys')): ?>
<script src="<?php echo REL_URL; ?>/misc/videojs-hotkeys/videojs.hotkeys.min.js"></script>
<?php endif; if (VCfg::get('player.videojs.persistvolume')): ?>
<script src="<?php echo REL_URL; ?>/misc/videojs-persistvolume/videojs.persistvolume.js"></script>
<?php endif; if (VCfg::get('player.videojs.watermark')): ?>
<script src="<?php echo REL_URL; ?>/misc/videojs-watermark/videojs.watermark.js"></script>
<?php endif; if (VCfg::get('player.videojs.thumbnails')): ?>
<script src="<?php echo REL_URL; ?>/misc/videojs-thumbnails/videojs.thumbnails.js"></script>
<?php endif; if ($this->vast): ?>
<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-ads/videojs.ads.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-ima/videojs.ima.min.js"></script>
<?php endif; if ($this->preroll): ?>
<script src="<?php echo REL_URL; ?>/misc/videojs-ads/videojs.ads.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/videojs-preroll/videojs-preroll.min.js"></script>
<?php endif; endif; ?>
<script type="text/javascript">
var ad_skip = 5;
$(document).ready(function() {
var player = videojs('player', {
  'controls': <?php echo (VCfg::get('player.videojs.controls')) ? 'true' : 'false'; ?>,
  'autoplay': <?php echo (VCfg::get('player.videojs.autoplay')) ? 'true' : 'false'; ?>,
  'preload': <?php echo (VCfg::get('player.videojs.preload')) ? "'auto'" : 'false'; ?>,
  'poster': '<?php echo THUMB_URL,'/',path($this->video_id); ?>/player.jpg',
  <?php if (VCfg::get('player.videojs.speed')): ?>'playbackRates': [0.5, 0.7, 1.0, 1.5, 2.0],
  <?php endif; ?>'controlBar': {
  'children': ['playToggle', 'currentTimeDisplay', 'progressControl', 'durationDisplay', 'chaptersButton', 'descriptionsButton', 'subtitlesButton', 'captionsButton', 'volumeMenuButton', 'playbackRateMenuButton', 'fullscreenToggle'],
  	'volumeMenuButton': {'inline': false, 'vertical': true}
  },
  'sources': [
  <?php if ($hls): ?>{'src':'<?php echo VHelper_video_hls::get($this->video_id, $this->video['server_id'], 'playlist.m3u8'); ?>', 'type':'application/x-mpegurl', 'withCredentials': false},<?php endif; ?>
  <?php if (!$hls or !$mobile): foreach ($this->files as $index => $file): $url = ($file['url'] != '') ? $file['url'] : VHelper_video_stream::get_urle($this->video_id, $file['file_id'], $file['postfix'], $file['ext'], $this->video['server_id']); ?>
  {'src':'<?php echo urldecode($url); ?>', 'type':'video/mp4', 'label':'<?php echo $file['resolution']; ?>', 'res':'<?php echo str_replace('p', '', $file['resolution']); ?>'}<?php if (isset($this->files[$index+1])): echo ', '; endif; ?>
  <?php endforeach; endif; ?>]<?php if ($this->video['hotlinked'] == '0'): ?>,
  'tracks': [{'kind':'metadata', 'src':'<?php echo THUMB_URL,'/',path($this->video_id); ?>/sprite.vtt'}]
  <?php endif; ?>
});
player.on('contextmenu', function(e) {e.preventDefault();});
player.on('pause', function() {$('#player-advertising').show();});
player.on('play', function() {$('#player-advertising').hide();});
<?php if (VCfg::get('player.videojs.resolution')): ?>
player.videoJsResolutionSwitcher({'default': 360, 'dynamicLabel': true});
<?php endif; if (VCfg::get('player.videojs.hotkeys')): ?>
player.hotkeys({volumeStep: 0.1, seekStep: 5, enableModifiersForNumbers: false});
<?php endif; if (VCfg::get('player.videojs.persistvolume')): ?>
player.persistvolume({namespace: 'persist-aspro'});
<?php endif; if (VCfg::get('player.videojs.thumbnails')): if (!$hls): ?>
player.on('loadedmetadata', function(){player.thumbnails({'width': <?php echo VCfg::get('video.thumb_sprite_width'); ?>, 'height': <?php echo VCfg::get('video.thumb_sprite_height'); ?>, 'basePath': '<?php echo BASE_URL,'/media/videos/tmb/',path($this->video_id); ?>/'});});
<?php endif; endif; if (VCfg::get('player.videojs.watermark') && $logo = VCfg::get('player.videojs.logo_url')): ?>
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
<?php endif; if ($this->vast): if ($this->vast['vast_text']): $vast = "'adsResponse': '".str_replace("\n", '', $this->vast['vast_text'])."'"; else: $vast = "'adTagUrl': '".$this->vast['vast_url']."'"; endif; ?>
player.ima({'id': 'player',<?php echo $vast; ?>});
<?php endif; if ($this->preroll): ?>
player.preroll({
  src: '<?php if ($this->preroll['media_url']): echo $this->preroll['media_url']; else: echo MEDIA_URL,'/ads/',$this->preroll['adv_id'],'.',$this->preroll['media_ext']; endif; ?>',
  href: '<?php echo BASE_URL,'/adv/',$this->preroll['adv_id']; ?>/',
<?php if ($this->preroll['skip_time'] > 0): ?>
  allowSkip: true,
  skipTime: <?php echo $this->preroll['skip_time']; ?>,
<?php else: ?>
  allowSkip: false,
<?php endif; ?>
  adSign: true,
  showRemaining: true,
  lang: {'skip': '<?php echo __('skip'); ?>', 'skip in': '<?php echo __('skip-in'); ?> ', 'advertisement': '<?php echo __('advertisement'); ?>', 'video start in': '<?php echo __('video-start-in'); ?>'}
});
<?php endif; ?>
$('#player-close').on('click', function(e) {e.preventDefault(); player.play();});
});
</script>
