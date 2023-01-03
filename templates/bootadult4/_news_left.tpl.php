<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="w-100 text-center">
  <h5><?php echo __('archive'); ?></h5>
</div>
<?php if ($this->dates): ?>
<div class="list-group list-group-small">
  <a href="" class="list-group-item list-group-item-action"><?php echo __('all'); ?></a>
  <?php foreach ($this->dates as $row): $time = strtotime($row['add_date'].'-01 00:00:01'); ?>
  <a href="<?php echo REL_URL.LANG.'/news/'.VDate::format($time, 'Y/m'); ?>/" class="list-group-item list-group-item-action"><?php echo VDate::format($time, 'F Y'); ?></a>
  <?php endforeach; ?>
</div>
<?php else: ?>
<div class="none"><?php echo __('no-news'); ?></div>
<?php endif; ?>