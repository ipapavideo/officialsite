<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <div class="content">
		<div class="panel panel-default">
		  <div class="panel-heading">
            <h1 class="panel-title panel-title-left"><?php echo e($this->title); ?></h1>
            <?php echo $this->fetch('_channel_menu'); ?>
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">
            <?php if ($this->channels): echo $this->fetch('_channel_list'); else: ?>
            <div class="none"><?php echo __('no-channels'); ?></div>
            <?php endif; ?>
          </div>
        </div>
        <nav class="text-center"><ul class="pagination pagination-lg"><?php echo p('pagination', $this->pagination, build_url($this->orientation, $this->letter, $this->order, true)); ?></ul></nav>
	  </div>
