<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php foreach ($this->topics as $topic): ?>
<div id="topic-<?php echo $topic['topic_id']; ?>" class="topic">
  <div class="topic-info">
	<div class="topic-read">
	  <?php $icon = ($this->user_id and $topic['last_post_id'] > $topic['r_post_id']) ? 'fa-comments' : 'fa-comments-o'; ?>
	  <i class="fa <?php echo $icon; ?> fa-2x"></i>
	</div>
	<div class="topic-title">
	  <?php if ($topic['sticky']): ?><span class="label label-warning topic-sticky"><?php echo __('sticky'); ?></span><?php endif; ?>
	  <a href="<?php echo REL_URL,LANG,'/forum/topic/',$topic['topic_id'],'/',$topic['slug']; ?>/"><?php echo e($topic['title']); ?></a>
	  <span class="topic-posted"><?php echo __('started-by'),' <span class="username">',e($topic['username']),'</span> ',__('on'),' ',VDate::format($topic['add_time'], 'd M Y'); ?></span>
	</div>
	<div class="clearfix"></div>
  </div>
  <div class="topic-stats">
	<span class="topic-count"><?php echo $topic['total_replies'],'</span> '; if ($topic['total_replies'] == '1'): echo __('reply'); else: echo __('replies'); endif; ?><br>
	<span class="topic-count"><?php echo $topic['total_views'],'</span> '; if ($topic['total_views'] == '1'): echo __('view'); else: echo __('views'); endif; ?>
  </div>
  <div class="topic-last">
	<?php echo __('by'),' <a href="',REL_URL,LANG,'/users/',e($topic['post_username']),'"><span class="username">',e($topic['post_username']); ?></span></a><br>
	<span class="content-info"><?php echo VDate::format($topic['last_post_time'], 'd M Y - h:i A'); ?></span>
  </div>
  <div class="clearfix"></div>
</div>
<?php endforeach; ?>
