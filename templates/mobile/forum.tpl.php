<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_forum.js'; ?>
	  <div id="content">
		<h1><?php echo e($this->title); ?></h1>
		<?php if ($this->categories): foreach ($this->categories as $category): ?>
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title pull-left"><?php echo e($category['name']); ?></h3>
			<div class="pull-right"><a href="#close" class="toggle toggle-open" data-id="<?php echo $category['cat_id']; ?>"><i class="fa fa-minus"></i></a></div>
			<div class="clearfix"></div>
		  </div>
		  <div id="forums-<?php echo $category['cat_id']; ?>" class="panel-body">
			<?php if ($forums = forums($category['cat_id'])): $total = count($forums); foreach ($forums as $index => $forum): $color = ($forum['color']) ? ' style="color: #'.$forum['color'].';"' : '';?>
			<div id="forum-<?php echo $forum['forum_id']; ?>" class="forum<?php if ($index === ($total-1)): echo ' forum-border'; endif; ?>">
			  <div class="forum-info">
  				<div class="forum-read">
    			  <?php $icon = ($this->user_id and ($forum['last_topic_id'] > $forum['r_topic_id'] or $forum['last_post_id'] > $forum['r_post_id'])) ? 'fa-comments' : 'fa-comments-o'; ?>
    			  <i class="fa <?php echo $icon; ?> fa-2x"<?php echo $color; ?>></i>
  				</div>
  				<div class="forum-title">
    			  <a href="<?php echo REL_URL,LANG,'/forum/',$forum['slug']; ?>/"<?php echo $color; ?>><?php echo e($forum['title']); ?></a>
    			  <?php if ($forum['description']): ?>
    			  <span class="forum-desc content-info"><?php echo e($forum['description']); ?></span>
    			  <?php endif; ?>
  				</div>
  				<div class="clearfix"></div>
			  </div>
			  <div class="forum-stats">
  				<span class="forum-count"><?php echo $forum['total_topics'],'</span> '; if ($forum['total_topics'] == '1'): echo __('topic'); else: echo __('topics'); endif; ?><br>
  				<span class="forum-count"><?php echo $forum['total_posts'],'</span> '; if ($forum['total_posts'] == '1'): echo __('post'); else: echo __('posts'); endif; ?>
			  </div>
			  <div class="forum-last">
  				<a href="<?php echo REL_URL,LANG,'/forum/topic/',$forum['last_topic_id'],'/',e($forum['topic_slug']); ?>/" class="btn-color"><?php echo e($forum['topic_title']); ?></a><br>
  				<span class="content-info"><?php echo __('by'),' <span class="username">',e($forum['username']),'</span> ',__('on'),' ',VDate::format($forum['last_topic_time'], 'd M Y - h:i A'); ?></span>
			  </div>
			  <div class="clearfix"></div>
			</div>
			<?php endforeach; else: ?>
			<div class="none"><?php echo __('no-forums'); ?></div>
			<?php endif; ?>
		  </div>
		</div>
		<?php endforeach; else: ?>
		<div class="none"><?php echo __('no-forum-categories'); ?></div>
		<div class="clearfix"></div>
		<?php endif; ?>
	  </div>
