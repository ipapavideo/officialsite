<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php $widgets = VCfg::get('template.bootadult4.widgets'); foreach ($widgets as $widget): echo w($widget); endforeach; ?>
