<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if ($this->player == 'play'): ?>
<?php if ($this->video['embed_code'] == ''): echo $this->fetch('premium_video_view_'.VCfg::get('premium.player')); else: ?>
<div id="player-container">
  <div id="player">
    <?php VHelper::load('module.video.embed'); ?>
    <?php echo VHelper_video_embed::responsive(str_replace('&amp;amp;', '&amp;', $this->video['embed_code'])); ?>
  </div>
</div>
<?php endif; elseif ($this->player == 'login'): ?>
<div class="player-none"><span><?php echo __('player-login', array('<a href="'.REL_URL.'/user/login/" class="login btn-link"><strong>','</strong></a>','<a href="'.REL_URL.'/premium/register/" class="btn-link"><strong>','</strong></a>')); ?></span></div>
<?php elseif ($this->player == 'upgrade'): ?>
<div class="player-none"><span><?php echo __('player-upgrade', array('<a href="'.REL_URL.'/premium/upgrade/" class="btn-link"><strong>','</strong></a>')); ?></span></div>
<?php elseif ($this->player == 'credit'): ?>
<div class="player-none"><span><?php echo __('player-credit', array('<a href="'.REL_URL.'/premium/credit/" class="btn-link"><strong>', '</strong></a>')); ?></span></div>
<?php elseif ($this->player == 'renew'): ?>
<div class="player-none"><span><?php echo __('player-renew', array('<a href="'.REL_URL.'/premium/renew/" class="btn-link"><strong>', '</strong></a>')); ?></span></div>
<?php endif; ?>
