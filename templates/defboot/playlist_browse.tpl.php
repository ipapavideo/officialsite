<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <div class="content">
		<div class="panel panel-default">
		  <div class="panel-heading">
            <h1 class="panel-title panel-title-left"><?php echo e($this->title); ?></h1>
            <?php echo $this->fetch('_playlist_menu'); ?>
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">
            <?php if ($this->playlists): echo $this->fetch('_playlist_list'); else: ?>
            <div class="none"><?php echo __('no-playlists'); ?></div>
            <?php endif; ?>
          </div>
        </div>
        <nav class="text-center"><ul class="pagination pagination-lg"><?php echo p('pagination', $this->pagination, build_url($this->orientation, $this->order, $this->timeline, true)); ?></ul></nav>
	  </div>
