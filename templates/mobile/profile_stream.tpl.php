<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if ($this->stream): echo $this->fetch('_stream_list'); else: ?>
<div class="none"><?php echo __('no-activity'); ?></div>
<?php endif; ?>
