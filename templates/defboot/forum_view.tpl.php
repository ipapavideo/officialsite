<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_forum.js'; ?>
	  <div id="content">
		<ol class="breadcrumb">
		  <li><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
		  <li><a href="<?php echo REL_URL,LANG,'/forum/',$this->forum['slug']; ?>"><?php echo e($this->forum['title']); ?></a></li>
		</ol>
		<div class="forum-header">
		  <div class="forum-pagination">
			<?php if ($this->pagination['total_pages'] > 1): ?>
			<nav><ul class="pagination pagination-xs"><?php echo p('pagination', $this->pagination, REL_URL.LANG.'/forum/'.$this->forum['slug'].'/#PAGE#/'); ?></ul></nav>
			<?php else: echo '<span class="content-info">',__('single-page'),'</span>'; endif; ?>			
		  </div>
		  <div class="forum-action">
			<?php if ($this->user_id): ?>
			  <?php if ($this->perms === true): ?>
			  <a href="<?php echo REL_URL,LANG; ?>/forum/post/<?php echo $this->forum['forum_id']; ?>/" class="btn btn-color"><strong><?php echo __('post-new-topic'); ?></strong></a>
			  <?php endif; ?>
			<?php else: ?>
			<a href="#login" class="login"><?php echo __('forum-login-post'); ?></a>
			<?php endif; ?>
		  </div>
		  <div class="clearfix"></div>
		</div>
		<div class="panel panel-default panel-forum">
		  <div class="panel-heading">
			<h3 class="panel-title"><?php echo e($this->forum['title']); ?></h3>
		  </div>
		  <div id="forum-<?php echo $this->forum['forum_id']; ?>" class="panel-body">
			<?php if ($this->topics): echo $this->fetch('_forum_topic_list'); else: ?>
			<div class="none"><?php echo __('no-topics'); ?></div>
			<?php endif; ?>
		  </div>
		</div>
		<div class="forum-footer">
		  <div class="forum-pagination">
			<?php if ($this->pagination['total_pages'] > 1): ?>
			<nav><ul class="pagination pagination-xs"><?php echo p('pagination', $this->pagination, REL_URL.LANG.'/forum/'.$this->forum['slug'].'/#PAGE#/'); ?></ul></nav>
			<?php else: echo '<span class="content-info">',__('single-page'),'</span>'; endif; ?>			
		  </div>
		  <div class="forum-action">
			<?php if ($this->user_id): ?>
			  <?php if ($this->perms === true): ?>
			  <a href="<?php echo REL_URL,LANG; ?>/forum/post/<?php echo $this->forum['forum_id']; ?>/" class="btn btn-color"><strong><?php echo __('post-new-topic'); ?></strong></a>
			  <?php endif; ?>
			<?php else: ?>
			<a href="#login" class="login"><?php echo __('forum-login-post'); ?></a>
			<?php endif; ?>
		  </div>
		  <div class="clearfix"></div>
		</div>
	  </div>
