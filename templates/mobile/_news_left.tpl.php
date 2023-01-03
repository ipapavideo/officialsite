<?php defined('_VALID') or die('Restricted Access!'); ?>
	  <div class="content-left">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title"><?php echo __('archive'); ?></h3>			
		  </div>
		  <div class="panel-body">
			<?php if ($this->dates): ?>
			<ul class="nav nav-stacked nav-list">
			  <li><a href=""><?php echo __('all'); ?></a></li>
			  <?php foreach ($this->dates as $row): $time = strtotime($row['add_date'].'-01 00:00:01'); ?>
			  <li><a href="<?php echo REL_URL.LANG.'/news/'.VDate::format($time, 'Y/m'); ?>/"><?php echo VDate::format($time, 'F Y'); ?></a></li>
			  <?php endforeach; ?>
			</ul>
			<?php else: ?>
			<div class="none"><?php echo __('no-news'); ?></div>
			<?php endif; ?>
		  </div>
		</div>
	  </div>
