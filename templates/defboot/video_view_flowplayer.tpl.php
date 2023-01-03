<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_video_view_flowplayer.js'; ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/flowplayer/skin/skin.css">
<div id="player-container">
  <?php $adv = p('adv_overlay'); if ($adv): echo $adv; endif; ?>
  <div id="player"></div>
</div>
