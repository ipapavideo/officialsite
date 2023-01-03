<?php defined('_VALID') or die('Restricted Access!'); ?>
<div id="report-container"></div>
<div id="delete-container"></div>
<div class="row">
  <div class="col-12">
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG,'/forum/',$this->topic['forum_slug']; ?>" title="<?php echo e($this->topic['forum_title']); ?>"><?php echo e($this->topic['forum_title']); ?></a></li>
        <li class="breadcrumb-item active"  aria-current="page"><?php echo e($this->topic['title']); ?></li>
      </ol>
	</nav>
	<h1 class="topic-title"><?php echo e($this->topic['title']); if ($this->topic['sticky']): ?><span class="badge badge-primary"><?php echo __('sticky'); ?></span><?php endif; ?></h1>
	<div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-between align-items-center forum-header">
      <div class="forum-pagination">
        <?php if ($this->pagination['total_pages'] > 1): ?>
        <nav aria-label="pagination"><ul class="pagination pagination-sm mb-1"><?php echo p('pagination', $this->pagination, REL_URL.LANG.'/forum/topic/'.$this->topic_id.'/'.$this->topic['slug'].'/#PAGE#/'); ?></ul></nav>
        <?php else: echo '<span class="content-info">',__('single-page'),'</span>'; endif; ?>
      </div>
      <div class="forum-action">
        <?php if ($this->topic['closed']): ?>
        <?php echo __('closed'); ?>
        <?php elseif ($this->user_id): ?>
        <?php if ($this->perms === true): ?>
        <a href="<?php echo REL_URL,LANG; ?>/forum/reply/<?php echo $this->topic_id; ?>/" class="btn btn-sm btn-primary"><?php echo __('post-reply'); ?></a>
        <?php endif; ?>
        <?php else: ?>
        <a href="#login" class="login btn btn-sm btn-outline-danger"><?php echo __('forum-login-post'); ?></a>
        <?php endif; ?>
      </div>
    </div>
    <div class="w-100 mt-1">
  	  <?php if ($this->pagination['page'] <= 1): $username = e($this->topic['username']); ?>
  	  <div id="topic-<?php echo $this->topic['topic_id']; ?>" class="media topic border rounded p-1 mb-1">
		<div class="media-left text-center pr-1">
  		  <a href="<?php echo REL_URL,LANG,'/users/',$username; ?>/" class="d-block">
  			<img src="<?php echo USER_URL,'/',avatar(false, $this->topic['user_id'], $this->topic['avatar'], $this->topic['gender'], true); ?>" alt="<?php echo __('user-avatar', $this->topic['username']); ?>" width="70" class="rounded">
  		  </a>
  		  <small class="text-muted"><?php echo $this->topic['posts'],' '; if ($this->topic['posts'] == '1'): echo __('post'); else: echo __('posts'); endif; ?></small>
  		</div>
  		<div class="media-body ml-3 p-1">
  		  <div class="d-flex justify-content-between align-items-center">
  			<h5><a href="<?php echo REL_URL,LANG,'/users/',$username; ?>/"><?php echo $username; ?></a> <small class="text-muted"><?php echo __('posted'),' ',VDate::format($this->topic['add_time'], 'd M Y - h:i A'); ?></small></h5>
  			<div class="topic-right">
  			  <a href="<?php echo REL_URL,LANG,'/forum/topic/',$this->topic_id; ?>/#t1">#1</a>
  			</div>
  		  </div>
  		  <p><?php echo nl2br($this->topic['content']); ?></p>
  		  <div class="d-flex justify-content-between border-top py-1">
  			<?php if ($this->topic['signature']): ?>
            <div class="signature"><?php echo nl2br($this->topic['signature']); ?></div>
            <?php endif; ?>
			<div class="topic-actions">
              <a href="<?php echo REL_URL,LANG,'/forum/reply/',$this->topic_id,'/?topic=',$this->topic['topic_id']; ?>" class="btn btn-xs btn-primary"><?php echo __('quote'); ?></a>
          	  <button class="btn btn-xs btn-forum-report" id="report-topic-<?php echo $this->topic['topic_id']; ?>" data-id="<?php echo $this->topic['topic_id']; ?>" data-type="topic"><i class="fa fa-flag"></i></button>
              <?php if ($this->allow_delete or $this->moderator): ?>
              <button class="btn btn-xs btn-forum-delete" data-id="<?php echo $this->topic['topic_id']; ?>" data-type="topic"><i class="fa fa-trash"></i></button>
              <?php endif; if ($this->user_id == $this->topic['user_id']): ?>
              <a href="<?php echo REL_URL,LANG,'/forum/edit/',$this->topic['topic_id']; ?>/" class="btn btn-xs"><i class="fa fa-edit"></i></a>
              <?php endif; ?>
            </div>
  		  </div>
  		</div>
  	  </div>
  	  <?php endif; if ($this->posts): echo $this->fetch('_forum_post_list'); endif; ?>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-between align-items-center forum-footer mt-1">
      <div class="forum-pagination">
        <?php if ($this->pagination['total_pages'] > 1): ?>
        <nav aria-label="pagination"><ul class="pagination pagination-sm"><?php echo p('pagination', $this->pagination, REL_URL.LANG.'/forum/topic/'.$this->topic_id.'/'.$this->topic['slug'].'/#PAGE#/'); ?></ul></nav>
        <?php else: echo '<span class="content-info">',__('single-page'),'</span>'; endif; ?>
      </div>
      <div class="forum-action align-self-center align-self-md-start">
        <?php if ($this->topic['closed']): ?>
        <?php echo __('closed'); ?>
        <?php elseif ($this->user_id): ?>
        <?php if ($this->perms === true): ?>
        <a href="<?php echo REL_URL,LANG; ?>/forum/reply/<?php echo $this->topic_id; ?>/" class="btn btn-sm btn-primary"><?php echo __('post-reply'); ?></a>
        <?php endif; ?>
        <?php else: ?>
        <a href="#login" class="login btn btn-sm btn-outline-danger"><?php echo __('forum-login-post'); ?></a>
        <?php endif; ?>
      </div>
    </div>
	<nav class="mt-2" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG; ?>/forum/"><?php echo __('forum'); ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo REL_URL,LANG,'/forum/',$this->topic['forum_slug']; ?>" title="<?php echo e($this->topic['forum_title']); ?>"><?php echo e($this->topic['forum_title']); ?></a></li>
        <li class="breadcrumb-item active"  aria-current="page"><?php echo e($this->topic['title']); ?></li>
      </ol>
	</nav>
  </div>
</div>