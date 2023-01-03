<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="content">
  <div class="left left-full">
	<?php $widgets = VCfg::get('template.defboot.widgets'); foreach ($widgets as $widget): echo w($widget); endforeach; ?>
  </div>
  <div class="clearfix"></div>
</div>

