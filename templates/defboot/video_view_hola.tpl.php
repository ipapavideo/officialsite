<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_view_hola.js'; $this->vast = p('adv_vast'); $this->preroll = false; if (!$this->vast): $this->preroll = p('adv_preroll'); endif; ?>
<div id="player-container">
  <?php $adv = p('adv_overlay'); if ($adv): echo $adv; endif; ?>  
  <video id="player" class="video-js vjs-default-skin vjs-big-play-centered">
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video!</a></p>
  </video>
</div>
