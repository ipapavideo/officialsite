<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_videos.js'; ?>
<?php echo $this->fetch('_user_header'); ?>
<input name="csrf_token" type="hidden" value="<?php echo $this->csrf_token; ?>">
<div id="response" class="w-100 d-none"><div class="alert alert-dismissible fade show" role="alert"></div></div>
<?php if ($this->videos): echo p('videos', $this->videos, '-user', $this->colmenu, $this->submenu); ?>
<nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
<?php else: ?>
<div class="none"><?php echo __('no-videos'); ?></div>
<?php endif; echo $this->fetch('_user_footer'); ?>
