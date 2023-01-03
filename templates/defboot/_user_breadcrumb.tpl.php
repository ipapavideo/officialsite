<?php defined('_VALID') or die('Restricted Access!'); ?>
<ol class="breadcrumb">
  <li<?php if ($this->submenu == 'user-dashboard'): echo ' class="active"'; endif; ?>><a href="<?php echo REL_URL,'/user/dashboard/">',__('dashboard'); ?></a></li>
  <li<?php if ($this->submenu != 'user-dashboard'): echo ' class="active"'; endif; ?>><a href="<?php echo CUR_URL,'">',e($this->title); ?></a></li>
</ol>       
