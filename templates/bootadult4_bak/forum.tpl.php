<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="row">
  <div class="col-12">
	<h1><?php echo e($this->title); ?></h1>
	<?php if ($this->categories): foreach ($this->categories as $category): ?>
	<div class="w-100 border rounded p-1 mb-2">
	  <h3><?php echo e($category['name']); ?></h3>
	  <?php if ($forums = forums($category['cat_id'])): $total = count($forums); foreach ($forums as $index => $forum): $color = ($forum['color']) ? ' style="color: #'.$forum['color'].';"' : '';?>
	  <div class="row no-gutters<?php if (isset($forums[$index+1])): ?> border-bottom<?php endif; ?>">
		<div class="col-12 col-sm-6 d-flex align-items-center">
    	  <div class="forum-read">
      		<?php $icon = ($this->user_id and ($forum['last_topic_id'] > $forum['r_topic_id'] or $forum['last_post_id'] > $forum['r_post_id'])) ? 'fa-comments' : 'fa-comments-o'; ?>
        	<i class="fa <?php echo $icon; ?> fa-2x"<?php echo $color; ?>></i>
      	  </div>
          <div class="d-flex flex-column forum-title ml-1">
        	<a href="<?php echo REL_URL,LANG,'/forum/',$forum['slug']; ?>/" class="h5 mb-0"<?php echo $color; ?>><?php echo e($forum['title']); ?></a>
            <?php if ($forum['description']): ?>
            <small class="forum-desc text-muted"><?php echo e($forum['description']); ?></small>
            <?php endif; ?>
          </div>
		</div>
		<div class="col-12 col-sm-6 d-flex align-items-center text-muted">
      	  <div class="flex-fill">
      		<div class="d-flex flex-column">
        	  <div><strong><?php echo $forum['total_topics'],'</strong> '; if ($forum['total_topics'] == '1'): echo __('topic'); else: echo __('topics'); endif; ?></div>
          	  <div><strong><?php echo $forum['total_posts'],'</strong> '; if ($forum['total_posts'] == '1'): echo __('post'); else: echo __('posts'); endif; ?></div>
            </div>
          </div>
          <div class="flex-fill align-items-end">
        	<?php if ($forum['last_topic_time'] > 0): ?>
        	<div class="d-flex flex-column align-items-end">
          	  <small class="font-weight-bold"><a href="<?php echo REL_URL,LANG,'/forum/topic/',$forum['last_topic_id'],'/',e($forum['topic_slug']); ?>/"><?php echo e($forum['topic_title']); ?></a></small>
          	  <small class="text-muted"><?php echo __('by'),' <span class="username">',e($forum['username']),'</span> ',__('on'),' ',VDate::format($forum['last_topic_time'], 'd M Y - h:i A'); ?></small>
            </div>
            <?php else: ?>
            <span>no reply</span>
            <?php endif; ?>
          </div>	  
		</div>
	  </div>
	  <?php endforeach; else: ?>
	  <div class="none"><?php echo __('no-forums'); ?></div>
	  <?php endif; ?>
	</div>
	<?php endforeach; else: ?>
	<div class="none"><?php echo __('no-forum-categories'); ?></div>
	<?php endif; ?>
  </div>
</div>
