<?php defined('_VALID') or die('Restricted Access!'); $adv = p('adv_overlay', 'video-embed-overlay'); if ($adv): $this->_js[] = '_video_view_embedded.js'; endif; ?>
<div id="player-container-fluid">
  <div id="player-fluid">
	  <?php if ($adv): echo $adv; endif; ?>
	  <?php VHelper::load('module.video.embed'); ?>
	  <?php echo VHelper_video_embed::responsive(str_replace('&amp;amp;', '&amp;', $this->video['embed_code'])); ?>
  </div>
</div>
