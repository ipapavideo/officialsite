<?php defined('_VALID') or die('Restricted Access!');  ?>
<script src="<?php echo REL_URL; ?>/misc/fluidplayer/fluidplayer.min.js"></script>
<script>
$(document).ready(function() {
  var width = $('#player-container-fluid').width();
  var height = width/1.777777778;
  $("#player-container-fluid").height(height);
  $("#player-fluid").show();

  var player = fluidPlayer('player-fluid', {
    layoutControls: {
      primaryColor: <?php if ($color = VCfg::get('player.fluidplayer.color')): echo "'".$color."'"; else: echo 'false'; endif; ?>,
      posterImage: <?php if (VCfg::get('player.fluidplayer.poster')): echo "'".THUMB_URL.'/'.path($this->video_id)."/player.jpg'"; else: echo 'false'; endif; ?>,
      playButtonShowing: <?php if (VCfg::get('player.fluidplayer.playbutton')): echo 'true'; else: echo 'false'; endif; ?>,
      playPauseAnimation: <?php if (VCfg::get('player.fluidplayer.playanimation')): echo 'true'; else: echo 'false'; endif; ?>,
      fillToContainer: true,
      autoPlay: <?php if (VCfg::get('player.fluidplayer.autoplay')): echo 'true'; else: echo 'false'; endif; ?>,
      mute: false,
      keyboardControl: <?php if (VCfg::get('player.fluidplayer.hotkeys')): echo 'true'; else: echo 'false'; endif; ?>,
      layout: 'default',
      allowDownload: false,
      playbackRateEnabled: <?php if (VCfg::get('player.fluidplayer.speed')): echo 'true'; else: echo 'false'; endif; ?>,
      allowTheatre: true,
      logo: {
        imageUrl: <?php if ($url = VCfg::get('player.fluidplayer.logo_url')): echo "'".$url."'"; else: echo 'null'; endif; ?>,
        position: '<?php echo str_replace('-', ' ', VCfg::get('player.fluidplayer.position')); ?>',
        clickUrl: '<?php echo CUR_URL; ?>',
        opacity: 1
      },
      controlBar: {
        autoHide: <?php if (VCfg::get('player.fluidplayer.controlhide')): echo 'true'; else: echo 'false'; endif; ?>,
        autoHideTimeout: 3,
        animated: true
      },
      timelinePreview:{<?php if (VCFg::get('player.fluidplayer.thumbnails') and $this->video['hotlinked'] == '0'): ?>file: '<?php echo THUMB_URL,'/',path($this->video_id); ?>/sprite.vtt', type: 'VTT', spriteRelativePath: true<?php endif; ?>}
    }
  });

  <?php if ($this->trailer): ?>
  player.on('pause', function() {$('#player-premium').show();});
  player.on('play', function() {$('#player-premium').hide();});
  player.on('ended', function() {$('#player-premium').show();});
  <?php endif; ?>

  $('#player-close').on('click', function(e) {e.preventDefault(); player.play();});
});
</script>

