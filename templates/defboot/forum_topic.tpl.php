<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_forum.js'; ?>
	  <div id="content">
		<div id="report-container"></div>
		<div id="delete-container"></div>
		<ol class="breadcrumb">
		  <li><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
		  <li><a href="<?php echo REL_URL,LANG,'/forum/',$this->topic['forum_slug']; ?>" title="<?php echo e($this->topic['forum_title']); ?>"><?php echo e($this->topic['forum_title']); ?></a></li>
		  <li><a href="<?php echo REL_URL,LANG,'/forum/topic/',$this->topic_id,'/',$this->topic['slug']; ?>/" title="<?php echo e($this->topic['title']); ?>"><?php echo e($this->topic['title']); ?></a></li>
		</ol>
		<div class="forum-header">
		  <div class="forum-pagination">
			<?php if ($this->pagination['total_pages'] > 1): ?>
			<nav><ul class="pagination pagination-xs"><?php echo p('pagination', $this->pagination, REL_URL.LANG.'/forum/topic/'.$this->topic_id.'/'.$this->topic['slug'].'/#PAGE#/'); ?></ul></nav>
			<?php else: echo '<span class="content-info">',__('single-page'),'</span>'; endif; ?>
		  </div>
		  <div class="forum-action">
			<?php if ($this->topic['closed']): ?>
			<?php echo __('closed'); ?>
			<?php elseif ($this->user_id): ?>
			  <?php if ($this->perms === true): ?>
			  <a href="<?php echo REL_URL,LANG; ?>/forum/reply/<?php echo $this->topic_id; ?>/" class="btn btn-color"><strong><?php echo __('post-reply'); ?></strong></a>
			  <?php endif; ?>
			<?php else: ?>
			<a href="#login" class="login"><strong><?php echo __('forum-login-post'); ?></strong></a>
			<?php endif; ?>
		  </div>
		  <div class="clearfix"></div>
		</div>
		<div class="panel panel-default panel-forum">
		  <div class="panel-heading">			
			<h1 class="panel-title pull-left"><?php echo e($this->topic['title']); ?></h1>
			<?php if ($this->topic['sticky']): ?>
			<span class="label label-warning pull-right"><?php echo __('sticky'); ?></span>
			<?php endif; ?>
			<div class="clearfix"></div>
		  </div>
		  <div class="panel-body">
			<div id="topic-<?php echo $this->topic['topic_id']; ?>" class="topic">
			  <div class="topic-user">
				<a href="<?php echo REL_URL,LANG,'/users/',e($this->topic['username']); ?>"><strong><?php echo e($this->topic['username']); ?></strong></a><br>
				<img src="<?php echo USER_URL,'/',avatar(false, $this->topic['user_id'], $this->topic['avatar'], $this->topic['gender'], true); ?>" alt="<?php echo __('user-avatar', $this->topic['username']); ?>" class="img-rounded"><br>
				<span class="topic-posts"><?php echo $this->topic['posts'],' '; if ($this->topic['posts'] == '1'): echo __('post'); else: echo __('posts'); endif; ?></span>
			  </div>
			  <div class="topic-content">
				<div class="topic-posted">
					<?php echo __('posted'),' ',VDate::format($this->topic['add_time'], 'd M Y - h:i A'); ?>
					<span class="pull-right"><a href="<?php echo REL_URL,LANG,'/forum/topic/',$this->topic_id; ?>/#t1">#1</a></span>
				</div>
				<div class="topic-text"><?php echo nl2br($this->topic['content']); ?></div>
  				<div class="topic-footer">
    			  <?php if ($this->topic['signature']): ?>
    			  <div class="signature"><?php echo nl2br($this->topic['signature']); ?></div>
    			  <?php endif; ?>
    			  <div class="topic-actions">    				
      				<button class="btn btn-menu btn-ns btn-forum-report" id="report-topic-<?php echo $this->topic['topic_id']; ?>" data-id="<?php echo $this->topic['topic_id']; ?>" data-type="topic"><?php echo __('report'); ?></button>
      				<?php if ($this->allow_delete or $this->moderator): ?>
      				<button class="btn btn-menu btn-ns btn-forum-delete" data-id="<?php echo $this->topic['topic_id']; ?>" data-type="topic"><?php echo __('delete'); ?></button>
      				<?php endif; if ($this->user_id == $this->topic['user_id']): ?>
      				<a href="<?php echo REL_URL,LANG,'/forum/edit/',$this->topic['topic_id']; ?>/" class="btn btn-menu btn-ns"><?php echo __('edit'); ?></a>
      				<?php endif; ?>
      				<a href="<?php echo REL_URL,LANG,'/forum/reply/',$this->topic_id,'/?topic=',$this->topic['topic_id']; ?>" class="btn btn-menu btn-ns"><?php echo __('quote'); ?></a>
    			  </div>
    			  <div class="clearfix"></div>
  				</div>
			  </div>			  
			  <div class="clearfix"></div>
			</div>
			<?php if ($this->posts): echo $this->fetch('_forum_post_list'); endif; ?>
		  </div>
		</div>
		<div class="forum-footer">
		  <div class="forum-pagination">
			<?php if ($this->pagination['total_pages'] > 1): ?>
			<nav><ul class="pagination pagination-xs"><?php echo p('pagination', $this->pagination, REL_URL.LANG.'/forum/topic/'.$this->topic_id.'/'.$this->topic['slug'].'/#PAGE#/'); ?></ul></nav>
			<?php else: echo '<span class="content-info">',__('single-page'),'</span>'; endif; ?>
		  </div>
		  <div class="forum-action">
			<?php if ($this->topic['closed']): ?>
			<?php echo __('closed'); ?>
			<?php elseif ($this->user_id): ?>
			  <?php if ($this->perms === true): ?>
			  <a href="<?php echo REL_URL,LANG; ?>/forum/reply/<?php echo $this->topic_id; ?>/" class="btn btn-color"><strong><?php echo __('post-reply'); ?></strong></a>
			  <?php endif; ?>
			<?php else: ?>
			<a href="#login" class="login"><strong><?php echo __('forum-login-post'); ?></strong></a>
			<?php endif; ?>
		  </div>
		  <div class="clearfix"></div>
		</div>
		<ol class="breadcrumb">
		  <li><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
		  <li><a href="<?php echo REL_URL,LANG,'/forum/',$this->topic['forum_slug']; ?>" title="<?php echo e($this->topic['forum_title']); ?>"><?php echo e($this->topic['forum_title']); ?></a></li>
		  <li><a href="<?php echo REL_URL,LANG,'/forum/topic/',$this->topic_id,'/',$this->topic['slug']; ?>/" title="<?php echo e($this->topic['title']); ?>"><?php echo e($this->topic['title']); ?></a></li>
		</ol>
	  </div>
