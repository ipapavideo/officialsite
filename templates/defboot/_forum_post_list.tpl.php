<?php defined('_VALID') or die('Restricted Access!'); $start = 0; if ($this->pagination['page'] > 1): $start = ($this->pagination['page']-1)*$this->pagination['items_per_page']; endif; ?>
<?php foreach ($this->posts as $index => $post): ?>
<div id="p<?php echo $post['post_id']; ?>" class="post">
  <div class="post-user">
	<a href="<?php echo REL_URL,LANG,'/users/',e($post['username']); ?>"><strong><?php echo e($post['username']); ?></strong></a><br>
	<div class="post-img">
  		<img src="<?php echo USER_URL,'/',avatar(false, $post['user_id'], $post['avatar'], $post['gender'], true); ?>" alt="<?php echo __('user-avatar', $post['username']); ?>" class="img-rounded"><br>
  	</div>
    <span class="topic-posts"><?php echo $post['posts'],' '; if ($post['posts'] == '1'): echo __('post'); else: echo __('posts'); endif; ?></span>    
  </div>
  <div class="post-content">
    <div class="post-posted">
  		<?php echo __('posted'),' ',VDate::format($post['add_time'], 'd M Y - h:i A'); ?>
  		 <span class="pull-right"><a href="<?php echo REL_URL,LANG,'/forum/topic/',$this->topic_id; ?>/#p<?php echo $post['post_id']; ?>">#<?php echo $start+$index+2; ?></a></span>
    </div>
    <div class="post-text"><?php echo nl2br($post['content']); ?></div>
    <div class="post-footer">
  	  <?php if ($post['signature']): ?>
  	  <div class="signature"><?php echo nl2br($post['signature']); ?></div>
  	  <?php endif; ?>
  	  <div class="post-actions">
  		<button class="btn btn-menu btn-ns btn-forum-report" id="report-post-<?php echo $post['post_id']; ?>" data-id="<?php echo $post['post_id']; ?>" data-type="post"><?php echo __('report'); ?></button>
  		<?php if ($this->moderator or $this->allow_delete): ?>
  		<button class="btn btn-menu btn-ns btn-forum-delete" data-id="<?php echo $post['post_id']; ?>" data-type="post"><?php echo __('delete'); ?></button>
  		<?php endif; if ($this->user_id == $post['user_id'] or $this->moderator): ?>
  		<a href="<?php echo REL_URL,LANG,'/forum/reply/edit/',$post['post_id']; ?>/" class="btn btn-menu btn-ns"><?php echo __('edit'); ?></a>
  		<?php endif; ?>
  		<a href="<?php echo REL_URL,LANG,'/forum/reply/',$this->topic_id,'/?post=',$post['post_id']; ?>" class="btn btn-menu btn-ns"><?php echo __('quote'); ?></a>
  	  </div>
  	  <div class="clearfix"></div>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
<?php endforeach; ?>
