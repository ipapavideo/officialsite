<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_search.js'; ?>
	  <div class="content">
		<div class="panel panel-default">
		  <div class="panel-heading">
            <h1 class="panel-title panel-title-left"><?php echo e($this->title); ?></h1>
            <?php echo $this->fetch('_user_search_menu'); ?>
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">
        	<?php echo $this->fetch('_user_search_filters'); ?>
            <?php if ($this->users): echo $this->fetch('_user_list'); else: ?>
            <div class="none"><?php echo __('no-users'); ?></div>
            <?php endif; ?>
          </div>
        </div>
        <nav class="text-center"><ul class="pagination"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
	  </div>
