<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <div id="content">
		<h1><?php echo e($this->title); ?></h1>
		<?php echo $this->fetch('_user_breadcrumb'); ?>
		<?php echo $this->Fetch('_user_menu'); ?>
		<div class="left left-full left-tab-content">
		