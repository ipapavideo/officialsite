<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_videos.js'; ?>
<?php echo $this->fetch('_user_header'); if ($this->stream): echo $this->fetch('_stream_list'); else: ?>
<div class="none"><?php echo __('no-activity'); ?></div>
<?php endif; echo $this->fetch('_user_footer'); ?>
