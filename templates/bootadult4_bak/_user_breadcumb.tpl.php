<?php defined('_VALID') or die('Restricted Access!'); ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
	<li class="breadcrumb-item<?php if ($this->submenu == 'user-dashboard'): echo ' active'; endif; ?>"><a href="<?php echo REL_URL,'/user/dashboard/">',__('dashboard'); ?></a></li>
	<li class="breadcrumb-item<?php if ($this->submenu != 'user-dashboard'): echo ' active'; endif; ?>"><a href="<?php echo CUR_URL,'">',e($this->title); ?></a></li>  
  </ol>
</nav>