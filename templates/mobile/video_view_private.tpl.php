<?php defined('_VALID') or die('Restricted Access!'); ?>
<div id="player-container">
  <div id="player">
	  <div class="private">
		<i class="fa fa-lock fa-5x"></i><br>
		<?php echo __('video-view-private', array('<a href="'.REL_URL.'/users/'.e($this->video['username']).'/" class="btn-link"><strong>'.e($this->video['username']).'</strong></a>')); ?>
	  </div>
  </div>
</div>
